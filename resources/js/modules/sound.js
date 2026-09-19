let audioContext;

function getContext() {
    const AudioContextClass = window.AudioContext || window.webkitAudioContext;
    if (!AudioContextClass) return null;

    audioContext ??= new AudioContextClass();

    // Browsers suspend a freshly created context until a user gesture — the
    // click that triggers this call already is one, so resuming here is
    // safe and just clears that suspended state before the tone plays.
    if (audioContext.state === 'suspended') {
        audioContext.resume().catch(() => {});
    }

    return audioContext;
}

// A short, synthesized UI click rather than an audio file — no asset to
// source, license, or load over the network, and it fires with zero
// latency. A quick downward sine sweep with a fast exponential decay reads
// as a crisp click rather than a musical tone.
export function playClick() {
    const ctx = getContext();
    if (!ctx) return;

    const oscillator = ctx.createOscillator();
    const gain = ctx.createGain();

    oscillator.type = 'sine';
    oscillator.frequency.setValueAtTime(880, ctx.currentTime);
    oscillator.frequency.exponentialRampToValueAtTime(220, ctx.currentTime + 0.08);

    gain.gain.setValueAtTime(0.15, ctx.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.09);

    oscillator.connect(gain);
    gain.connect(ctx.destination);

    oscillator.start();
    oscillator.stop(ctx.currentTime + 0.1);
}
