// Renders the [data-thermal-heatmap] canvases with a small hand-written
// WebGL1 shader: a domain-warped fbm field mapped through a cold-to-hot
// palette, with independently pulsing "hotspot" cores, faint topographic
// isoline contours, and a cursor-pressed thermal bloom that cools back down
// over ~2 seconds at rest. Composited with real alpha transparency (see
// fluid-smoke.js for the same technique) so cold zones can fade into
// whatever the host section already looks like.
import {
    hexToRgb,
    createFullscreenProgram,
    getUniformLocations,
    resizeCanvasToDisplaySize,
    runAnimatedCanvas,
} from './webgl-canvas';

const FRAGMENT_SHADER = `
precision mediump float;

uniform vec2 u_resolution;
uniform float u_time;
uniform vec3 u_palette[6];
uniform int u_paletteCount;
uniform vec3 u_bg;
uniform float u_bgAlpha;
uniform float u_speed;
uniform float u_scale;
uniform int u_hotspots;
uniform float u_glow;
uniform float u_flow;
uniform float u_contrast;
uniform float u_contours;
uniform vec2 u_mouse;
uniform float u_mouseAmount;

float hash1(float n) {
    return fract(sin(n) * 43758.5453123);
}

float hash(vec2 p) {
    return fract(sin(dot(p, vec2(127.1, 311.7))) * 43758.5453123);
}

float noise(vec2 p) {
    vec2 i = floor(p);
    vec2 f = fract(p);
    float a = hash(i);
    float b = hash(i + vec2(1.0, 0.0));
    float c = hash(i + vec2(0.0, 1.0));
    float d = hash(i + vec2(1.0, 1.0));
    vec2 u = f * f * (3.0 - 2.0 * f);
    return mix(a, b, u.x) + (c - a) * u.y * (1.0 - u.x) + (d - b) * u.x * u.y;
}

float fbm(vec2 p) {
    // 4 octaves rather than 5 — this function runs up to 5 times per pixel
    // (the domain-warp field plus the final lookup), so each octave saved
    // here is a real per-pixel cost, and the field is soft/blurred enough
    // that a fourth octave of detail isn't missed.
    float v = 0.0;
    float amp = 0.5;
    for (int i = 0; i < 4; i++) {
        v += amp * noise(p);
        p *= 2.02;
        amp *= 0.5;
    }
    return v;
}

// Same constant-bound palette walk as fluid-smoke.js — see the comment
// there for why the loop is written this way (WebGL1 array-index rules).
vec3 paletteColor(float t) {
    float scaled = clamp(t, 0.0, 1.0) * float(u_paletteCount - 1);
    vec3 result = u_palette[0];
    for (int i = 0; i < 5; i++) {
        if (i < u_paletteCount - 1) {
            float segStart = float(i);
            float w = clamp(scaled - segStart, 0.0, 1.0);
            vec3 segColor = mix(u_palette[i], u_palette[i + 1], w);
            if (scaled >= segStart) {
                result = segColor;
            }
        }
    }
    return result;
}

void main() {
    vec2 uv = gl_FragCoord.xy / u_resolution;
    vec2 centered = uv - 0.5;
    centered.x *= u_resolution.x / u_resolution.y;

    vec2 p = centered * (1.6 * u_scale);

    vec2 flowDir = normalize(vec2(1.0, 0.55));
    p += flowDir * u_time * u_speed * u_flow * 0.15;

    float t = u_time * u_speed * 0.12;

    // Domain-warped fbm ambient thermal field (same "warp fbm through fbm"
    // technique as fluid-smoke.js).
    vec2 q = vec2(fbm(p + t), fbm(p + vec2(4.3, 2.1) - t));
    vec2 r = vec2(
        fbm(p + 2.5 * q + vec2(1.1, 3.4) + t * 1.3),
        fbm(p + 2.5 * q + vec2(6.2, 0.8) - t * 1.1)
    );
    float heat = fbm(p + 2.0 * r);

    heat = clamp((heat - 0.5) * u_contrast + 0.5, 0.0, 1.0);

    // Independent pulsing hotspots, fixed screen-space positions (not
    // warped by the flow) so each reads as a distinct focal flare rather
    // than part of the churning ambient texture. Fixed 8-iteration loop —
    // WebGL1 needs a constant bound — skipped once i reaches u_hotspots.
    float bloom = 0.0;
    for (int i = 0; i < 8; i++) {
        if (i < u_hotspots) {
            float fi = float(i);
            vec2 corePos = vec2(hash1(fi * 1.7 + 1.0), hash1(fi * 3.1 + 7.0)) * 1.3 - 0.65;
            float driftAngle = hash1(fi * 5.3 + 2.0) * 6.28318;
            corePos += vec2(cos(driftAngle), sin(driftAngle)) * 0.12 * sin(t * 0.4 + fi * 11.0);

            float pulseSpeed = 0.35 + hash1(fi * 2.3 + 3.0) * 0.65;
            float phase = hash1(fi * 4.1 + 5.0) * 6.28318;
            float pulse = 0.5 + 0.5 * sin(u_time * u_speed * pulseSpeed + phase);

            // Radius widens with u_glow (wider halos at higher glow); the
            // whole contribution is multiplied by u_glow too, so glow=0
            // silences hotspots entirely rather than leaving a dim ember.
            float radius = 0.08 + hash1(fi * 6.7 + 4.0) * 0.05 + u_glow * 0.05;
            float dist = length(centered - corePos);
            bloom += exp(-dist * dist / (radius * radius)) * pulse * u_glow;
        }
    }
    heat += bloom * 0.5;

    // Cursor bloom: a direct thermal press rather than a field distortion —
    // a tight core plus a wider halo, like a thumb on a thermal camera.
    vec2 mouseUv = u_mouse - 0.5;
    mouseUv.x *= u_resolution.x / u_resolution.y;
    float mouseDist = length(centered - mouseUv);
    float mouseCore = exp(-mouseDist * mouseDist / 0.006);
    float mouseHalo = exp(-mouseDist * mouseDist / 0.045) * 0.5;
    heat += (mouseCore + mouseHalo) * u_mouseAmount * 1.1;

    heat = clamp(heat, 0.0, 1.0);

    vec3 thermalColor = paletteColor(heat);

    // Faint topographic isoline rings traced around heat levels.
    float cv = heat * u_contours;
    float frac = fract(cv);
    float distToLine = min(frac, 1.0 - frac);
    float contourMask = u_contours > 0.0 ? 1.0 - smoothstep(0.0, 0.05, distToLine) : 0.0;
    thermalColor = mix(thermalColor, vec3(1.0), contourMask * 0.15);

    // Manual premultiplied "over" compositing (see fluid-smoke.js): cold
    // (low-heat) areas fade toward transparent so the host section's own
    // background shows through, unless u_bgAlpha fills them with u_bg.
    vec3 premulBg = u_bg * u_bgAlpha;
    vec3 premulHeat = thermalColor * heat;
    vec3 outColor = premulHeat + premulBg * (1.0 - heat);
    float outAlpha = heat + u_bgAlpha * (1.0 - heat);

    gl_FragColor = vec4(outColor, outAlpha);
}
`;

const MAX_PALETTE_STOPS = 6;
const UNIFORM_NAMES = [
    'u_resolution', 'u_time', 'u_bg', 'u_bgAlpha', 'u_speed', 'u_scale',
    'u_hotspots', 'u_glow', 'u_flow', 'u_contrast', 'u_contours',
    'u_mouse', 'u_mouseAmount', 'u_paletteCount', 'u_palette',
];

// A couple of seconds for the cursor bloom to cool back to the ambient
// field once the pointer stops moving, per the effect's own description.
const MOUSE_COOLDOWN_MS = 2000;

function setupGl(canvas) {
    const gl = canvas.getContext('webgl', { alpha: true, premultipliedAlpha: true })
        || canvas.getContext('experimental-webgl', { alpha: true, premultipliedAlpha: true });
    if (!gl) return null;

    const program = createFullscreenProgram(gl, FRAGMENT_SHADER, 'Thermal heatmap');
    if (!program) return null;

    return { gl, uniforms: getUniformLocations(gl, program, UNIFORM_NAMES) };
}

function readConfig(canvas) {
    const data = canvas.dataset;
    const palette = (data.palette || '#000004,#420a68,#932667,#dd513a,#fca50a,#fcffa4')
        .split(',')
        .map((hex) => hex.trim())
        .filter(Boolean)
        .slice(0, MAX_PALETTE_STOPS)
        .map(hexToRgb);

    return {
        palette,
        bg: hexToRgb(data.bg || '#050208'),
        bgAlpha: parseFloat(data.bgAlpha ?? '0.55'),
        speed: parseFloat(data.speed ?? '0.35'),
        scale: parseFloat(data.scale ?? '1'),
        hotspots: parseInt(data.hotspots ?? '3', 10),
        glow: parseFloat(data.glow ?? '1'),
        flow: parseFloat(data.flow ?? '0.4'),
        contrast: parseFloat(data.contrast ?? '1.2'),
        contours: parseFloat(data.contours ?? '0'),
        mouseStrength: parseFloat(data.mouse ?? '0.5'),
    };
}

function runCanvas(canvas, prefersReducedMotion) {
    const setup = setupGl(canvas);
    if (!setup) {
        // No WebGL — leave the CSS gradient fallback on the wrapper visible.
        canvas.style.display = 'none';
        return;
    }

    const { gl, uniforms } = setup;
    const config = readConfig(canvas);
    const paletteFlat = new Float32Array(MAX_PALETTE_STOPS * 3);
    config.palette.forEach((rgb, i) => paletteFlat.set(rgb, i * 3));

    gl.clearColor(0, 0, 0, 0);

    let mouseTarget = [0.5, 0.5];
    let lastMoveTime = -Infinity;
    const canInteract = config.mouseStrength > 0 && !prefersReducedMotion;

    if (canInteract) {
        canvas.addEventListener('pointermove', (event) => {
            const rect = canvas.getBoundingClientRect();
            mouseTarget = [
                (event.clientX - rect.left) / rect.width,
                1 - (event.clientY - rect.top) / rect.height,
            ];
            lastMoveTime = performance.now();
        });
    }

    const render = (time) => {
        resizeCanvasToDisplaySize(canvas, gl);

        const idleMs = performance.now() - lastMoveTime;
        const mouseHeat = Math.max(0, 1 - idleMs / MOUSE_COOLDOWN_MS);

        gl.clear(gl.COLOR_BUFFER_BIT);

        gl.uniform2f(uniforms.u_resolution, canvas.width, canvas.height);
        gl.uniform1f(uniforms.u_time, prefersReducedMotion ? 0 : time / 1000);
        gl.uniform3fv(uniforms.u_bg, config.bg);
        gl.uniform1f(uniforms.u_bgAlpha, config.bgAlpha);
        gl.uniform1f(uniforms.u_speed, config.speed);
        gl.uniform1f(uniforms.u_scale, config.scale);
        gl.uniform1i(uniforms.u_hotspots, config.hotspots);
        gl.uniform1f(uniforms.u_glow, config.glow);
        gl.uniform1f(uniforms.u_flow, config.flow);
        gl.uniform1f(uniforms.u_contrast, config.contrast);
        gl.uniform1f(uniforms.u_contours, config.contours);
        gl.uniform2f(uniforms.u_mouse, mouseTarget[0], mouseTarget[1]);
        gl.uniform1f(uniforms.u_mouseAmount, mouseHeat * config.mouseStrength);
        gl.uniform1i(uniforms.u_paletteCount, config.palette.length);
        gl.uniform3fv(uniforms.u_palette, paletteFlat);

        gl.drawArrays(gl.TRIANGLES, 0, 3);
    };

    runAnimatedCanvas(canvas, { prefersReducedMotion, render });
}

export function initThermalHeatmap() {
    const canvases = document.querySelectorAll('[data-thermal-heatmap]');
    if (!canvases.length) return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    canvases.forEach((canvas) => runCanvas(canvas, prefersReducedMotion));
}
