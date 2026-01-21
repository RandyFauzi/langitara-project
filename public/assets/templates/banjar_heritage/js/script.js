/* public/assets/templates/banjar_heritage/js/script.js */

document.addEventListener('DOMContentLoaded', function () {
    const coverSection = document.getElementById('cover-section');
    const openBtn = document.getElementById('open-btn');
    const audio = document.getElementById('bg-music');
    const musicControl = document.getElementById('music-control');
    const musicIcon = musicControl.querySelector('i');
    let isPlaying = false;

    // Handle Open Invitation
    openBtn.addEventListener('click', function () {
        // 1. Scroll/Unlock Body
        document.body.style.overflowY = 'auto';

        // 2. Hide Cover (Slide Up Effect)
        coverSection.style.transition = 'transform 1.2s ease-in-out';
        coverSection.style.transform = 'translateY(-100vh)';

        // 3. Play Music
        audio.play().then(() => {
            isPlaying = true;
            musicControl.classList.remove('hidden');
            musicIcon.classList.add('fa-spin');
        }).catch(err => {
            console.log("Autoplay blocked, waiting for interaction");
        });
    });

    // Music Toggle
    musicControl.addEventListener('click', function () {
        if (isPlaying) {
            audio.pause();
            musicIcon.classList.remove('fa-spin');
            musicIcon.classList.remove('fa-compact-disc');
            musicIcon.classList.add('fa-volume-mute');
        } else {
            audio.play();
            musicIcon.classList.add('fa-spin');
            musicIcon.classList.add('fa-compact-disc');
            musicIcon.classList.remove('fa-volume-mute');
        }
        isPlaying = !isPlaying;
    });

    // Simple Intersection Observer for Fade Up Animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
});
