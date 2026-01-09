// --- Scroll Animation ---
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in-up');
        }
    });
}, { threshold: 0.1 });

// Use a safer selector or ensure DOM is ready. 
// Ideally, the script is deferred, so DOM elements should be available.
document.querySelectorAll('section > div').forEach((el) => {
    observer.observe(el);
});

// --- Music Player Logic ---
const music = document.getElementById('bg-music');
const btnMusic = document.getElementById('music-control');
const iconPlay = document.getElementById('icon-play');
const iconPause = document.getElementById('icon-pause');
let isPlaying = true;

if (music && btnMusic) {
    // Auto-play attempt (often blocked by browser policy until interaction)
    window.addEventListener('click', () => {
        if (!isPlaying && music.paused) {
            toggleMusic();
        }
    }, { once: true });
}

function toggleMusic() {
    if (music.paused) {
        music.play();
        iconPlay.classList.add('hidden');
        iconPause.classList.remove('hidden');
        btnMusic.classList.add('animate-spin-slow');
        isPlaying = true;
    } else {
        music.pause();
        iconPlay.classList.remove('hidden');
        iconPause.classList.add('hidden');
        btnMusic.classList.remove('animate-spin-slow');
        isPlaying = false;
    }
}

// --- Toast Notification Logic ---
function showToast(message) {
    const container = document.getElementById('toast-container');
    const msgSpan = document.getElementById('toast-message');

    if (!container || !msgSpan) return;

    msgSpan.innerText = message;

    // Show
    container.classList.remove('opacity-0', 'translate-y-10', 'pointer-events-none');

    // Hide after 3s
    setTimeout(() => {
        container.classList.add('opacity-0', 'translate-y-10', 'pointer-events-none');
    }, 3000);
}
