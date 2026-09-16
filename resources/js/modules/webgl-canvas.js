// Shared WebGL1 plumbing for the site's hand-written shader backgrounds
// (fluid-smoke, thermal-heatmap, ...): compiling a fullscreen-triangle program,
// resizing to the element's display size, and an off-screen-pause render
// loop. Kept dependency-free — each effect still owns its own shader source
// and uniform wiring.

const DEFAULT_VERTEX_SHADER = `
attribute vec2 a_position;

void main() {
    gl_Position = vec4(a_position, 0.0, 1.0);
}
`;

export function hexToRgb(hex) {
    const normalized = hex.replace('#', '').trim();
    const expanded = normalized.length === 3
        ? normalized.split('').map((c) => c + c).join('')
        : normalized;
    const value = parseInt(expanded, 16) || 0;

    return [
        ((value >> 16) & 255) / 255,
        ((value >> 8) & 255) / 255,
        (value & 255) / 255,
    ];
}

function compileShader(gl, type, source, label) {
    const shader = gl.createShader(type);
    gl.shaderSource(shader, source);
    gl.compileShader(shader);

    if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
        console.error(`${label} shader failed to compile:`, gl.getShaderInfoLog(shader));
        gl.deleteShader(shader);
        return null;
    }

    return shader;
}

// Creates a program paired with the standard "big triangle" fullscreen pass
// (cheaper than a quad — no shared edge to rasterise twice) and binds its
// position attribute, ready to draw with `gl.drawArrays(gl.TRIANGLES, 0, 3)`.
export function createFullscreenProgram(gl, fragmentSource, label) {
    const vertexShader = compileShader(gl, gl.VERTEX_SHADER, DEFAULT_VERTEX_SHADER, label);
    const fragmentShader = compileShader(gl, gl.FRAGMENT_SHADER, fragmentSource, label);
    if (!vertexShader || !fragmentShader) return null;

    const program = gl.createProgram();
    gl.attachShader(program, vertexShader);
    gl.attachShader(program, fragmentShader);
    gl.linkProgram(program);

    if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
        console.error(`${label} program failed to link:`, gl.getProgramInfoLog(program));
        return null;
    }

    gl.useProgram(program);

    const positionBuffer = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 3, -1, -1, 3]), gl.STATIC_DRAW);

    const positionLocation = gl.getAttribLocation(program, 'a_position');
    gl.enableVertexAttribArray(positionLocation);
    gl.vertexAttribPointer(positionLocation, 2, gl.FLOAT, false, 0, 0);

    return program;
}

export function getUniformLocations(gl, program, names) {
    const uniforms = {};
    names.forEach((name) => {
        uniforms[name] = gl.getUniformLocation(program, name);
    });
    return uniforms;
}

export function resizeCanvasToDisplaySize(canvas, gl) {
    // Capped at 1.5 rather than the full device pixel ratio — retina
    // screens still look sharp for a soft, blurred field like these, and it
    // cuts fragment-shader work (every octave of noise, per pixel) by
    // roughly half compared to a cap of 2.
    const dpr = Math.min(window.devicePixelRatio || 1, 1.5);
    const width = Math.max(1, Math.round(canvas.clientWidth * dpr));
    const height = Math.max(1, Math.round(canvas.clientHeight * dpr));
    if (canvas.width !== width || canvas.height !== height) {
        canvas.width = width;
        canvas.height = height;
        gl.viewport(0, 0, width, height);
        return true;
    }
    return false;
}

// Paints one frame immediately (so there's no blank flash while waiting on
// the IntersectionObserver's first callback), then — unless the visitor
// prefers reduced motion, in which case that single frame is the final
// state — drives a requestAnimationFrame loop that only runs while the
// canvas is both on-screen AND the tab itself is visible (switching tabs or
// minimising the window stops every canvas at once, same as scrolling one
// off-screen does individually).
export function runAnimatedCanvas(canvas, { prefersReducedMotion, render }) {
    render(0);

    if (prefersReducedMotion) return;

    let rafId = null;
    let isIntersecting = false;

    const loop = (time) => {
        render(time);
        rafId = requestAnimationFrame(loop);
    };
    const start = () => {
        if (rafId === null) rafId = requestAnimationFrame(loop);
    };
    const stop = () => {
        if (rafId !== null) {
            cancelAnimationFrame(rafId);
            rafId = null;
        }
    };
    const sync = () => {
        if (isIntersecting && !document.hidden) {
            start();
        } else {
            stop();
        }
    };

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            (entries) => entries.forEach((entry) => {
                isIntersecting = entry.isIntersecting;
                sync();
            }),
            { threshold: 0.01 },
        );
        observer.observe(canvas);
    } else {
        isIntersecting = true;
        sync();
    }

    document.addEventListener('visibilitychange', sync);
}
