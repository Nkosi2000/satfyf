// Renders the [data-fluid-smoke] canvases with a small hand-written WebGL1
// shader: domain-warped fbm noise (the classic "warp fbm inside fbm"
// technique) shaped into soft volumetric plumes, composited over whatever
// sits behind the canvas via real alpha transparency — this one is meant to
// sit inside an existing section (the footer) rather than behave as a
// self-contained panel.
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
uniform vec3 u_palette[4];
uniform int u_paletteCount;
uniform vec3 u_bg;
uniform float u_bgAlpha;
uniform float u_speed;
uniform float u_scale;
uniform float u_warp;
uniform float u_rise;
uniform float u_swirl;
uniform float u_contrast;
uniform float u_softness;
uniform vec2 u_mouse;
uniform float u_mouseAmount;

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

vec2 rotate2(vec2 v, float a) {
    float s = sin(a);
    float c = cos(a);
    return vec2(v.x * c - v.y * s, v.x * s + v.y * c);
}

// Constant-bound palette walk so every array access uses a literal index —
// WebGL1/GLSL ES 1.00 only guarantees array indexing with constant
// expressions inside fragment shaders (see thermal-heatmap.js for the same
// pattern).
vec3 paletteColor(float t) {
    float scaled = clamp(t, 0.0, 1.0) * float(u_paletteCount - 1);
    vec3 result = u_palette[0];
    for (int i = 0; i < 3; i++) {
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
    p.y -= u_rise * u_time * u_speed * 0.6;

    // Pointer stir: a soft vortex curl around the cursor, fading with
    // distance and settling back out once u_mouseAmount decays to 0.
    vec2 mouseUv = u_mouse - 0.5;
    mouseUv.x *= u_resolution.x / u_resolution.y;
    vec2 toMouse = centered - mouseUv;
    float mouseFalloff = exp(-length(toMouse) * 2.2) * u_mouseAmount;
    p += (rotate2(toMouse, 1.6) - toMouse) * mouseFalloff;

    float t = u_time * u_speed * 0.15;

    // Domain warp: warp the sample point through one fbm field, then warp
    // it again through a second fbm of the warped result, before the final
    // fbm lookup — each pass adds another layer of marbled/curling detail.
    vec2 q = vec2(fbm(p + t), fbm(p + vec2(5.2, 1.3) - t));
    q = rotate2(q, u_swirl * 2.4);

    vec2 r = vec2(
        fbm(p + u_warp * 4.0 * q + vec2(1.7, 9.2) + t * 1.5),
        fbm(p + u_warp * 4.0 * q + vec2(8.3, 2.8) + t * 1.13)
    );
    r = rotate2(r, u_swirl * 1.2);

    float density = fbm(p + u_warp * 4.0 * r);

    density = clamp((density - 0.5) * u_contrast + 0.5, 0.0, 1.0);
    density = smoothstep(1.0 - u_softness, 1.0, density);

    vec3 smokeColor = paletteColor(1.0 - density);

    // Manual premultiplied "over" compositing: an optional flat backing
    // tint (u_bg at u_bgAlpha) sits behind the smoke, and the smoke itself
    // composites on top by its own density — at u_bgAlpha 0 the backing
    // layer contributes nothing, leaving the canvas transparent wherever
    // there's no smoke, so the section's own background shows through.
    vec3 premulBg = u_bg * u_bgAlpha;
    vec3 premulSmoke = smokeColor * density;
    vec3 outColor = premulSmoke + premulBg * (1.0 - density);
    float outAlpha = density + u_bgAlpha * (1.0 - density);

    gl_FragColor = vec4(outColor, outAlpha);
}
`;

const MAX_PALETTE_STOPS = 4;
const UNIFORM_NAMES = [
    'u_resolution', 'u_time', 'u_bg', 'u_bgAlpha', 'u_speed', 'u_scale',
    'u_warp', 'u_rise', 'u_swirl', 'u_contrast', 'u_softness',
    'u_mouse', 'u_mouseAmount', 'u_paletteCount', 'u_palette',
];

function setupGl(canvas) {
    const gl = canvas.getContext('webgl', { alpha: true, premultipliedAlpha: true })
        || canvas.getContext('experimental-webgl', { alpha: true, premultipliedAlpha: true });
    if (!gl) return null;

    const program = createFullscreenProgram(gl, FRAGMENT_SHADER, 'Fluid smoke');
    if (!program) return null;

    return { gl, uniforms: getUniformLocations(gl, program, UNIFORM_NAMES) };
}

function readConfig(canvas) {
    const data = canvas.dataset;
    const palette = (data.palette || '#8a8680,#4d4a45')
        .split(',')
        .map((hex) => hex.trim())
        .filter(Boolean)
        .slice(0, MAX_PALETTE_STOPS)
        .map(hexToRgb);

    return {
        palette,
        bg: hexToRgb(data.bg || '#000000'),
        bgAlpha: parseFloat(data.bgAlpha ?? '0'),
        speed: parseFloat(data.speed ?? '0.3'),
        scale: parseFloat(data.scale ?? '1'),
        warp: parseFloat(data.warp ?? '1'),
        rise: parseFloat(data.rise ?? '0.3'),
        swirl: parseFloat(data.swirl ?? '0.3'),
        contrast: parseFloat(data.contrast ?? '1.3'),
        softness: parseFloat(data.softness ?? '0.55'),
        mouseStrength: parseFloat(data.mouse ?? '0.3'),
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
    let mouseInfluence = 0;
    let hasMouseMoved = false;
    const canInteract = config.mouseStrength > 0 && !prefersReducedMotion;

    // The canvas is pointer-events:none (the footer's links have to stay
    // clickable through it), so it can never itself receive pointer events.
    // Tracking on `window` instead, and computing the canvas-relative
    // position by hand, gets the same cursor-stir effect without stealing
    // any clicks — and the shader's own exponential distance falloff
    // already fades the effect to nothing once the cursor is far from the
    // canvas, so there's no need for enter/leave tracking on top of this.
    if (canInteract) {
        window.addEventListener('pointermove', (event) => {
            const rect = canvas.getBoundingClientRect();
            mouseTarget = [
                (event.clientX - rect.left) / rect.width,
                1 - (event.clientY - rect.top) / rect.height,
            ];
            hasMouseMoved = true;
        }, { passive: true });
    }

    const render = (time) => {
        resizeCanvasToDisplaySize(canvas, gl);
        mouseInfluence += ((hasMouseMoved ? 1 : 0) - mouseInfluence) * 0.06;

        gl.clear(gl.COLOR_BUFFER_BIT);

        gl.uniform2f(uniforms.u_resolution, canvas.width, canvas.height);
        gl.uniform1f(uniforms.u_time, prefersReducedMotion ? 0 : time / 1000);
        gl.uniform3fv(uniforms.u_bg, config.bg);
        gl.uniform1f(uniforms.u_bgAlpha, config.bgAlpha);
        gl.uniform1f(uniforms.u_speed, config.speed);
        gl.uniform1f(uniforms.u_scale, config.scale);
        gl.uniform1f(uniforms.u_warp, config.warp);
        gl.uniform1f(uniforms.u_rise, config.rise);
        gl.uniform1f(uniforms.u_swirl, config.swirl);
        gl.uniform1f(uniforms.u_contrast, config.contrast);
        gl.uniform1f(uniforms.u_softness, config.softness);
        gl.uniform2f(uniforms.u_mouse, mouseTarget[0], mouseTarget[1]);
        gl.uniform1f(uniforms.u_mouseAmount, mouseInfluence * config.mouseStrength);
        gl.uniform1i(uniforms.u_paletteCount, config.palette.length);
        gl.uniform3fv(uniforms.u_palette, paletteFlat);

        gl.drawArrays(gl.TRIANGLES, 0, 3);
    };

    runAnimatedCanvas(canvas, { prefersReducedMotion, render });
}

export function initFluidSmoke() {
    const canvases = document.querySelectorAll('[data-fluid-smoke]');
    if (!canvases.length) return;

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    canvases.forEach((canvas) => runCanvas(canvas, prefersReducedMotion));
}
