document.addEventListener('DOMContentLoaded', function () {
    const openBtn = document.getElementById('open-invitation');
    const coverSection = document.getElementById('cover-section');
    const container = document.querySelector('.relative.w-full.max-w-md'); // The main container

    // 1. Open Invitation Logic
    if (openBtn && coverSection) {
        openBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // Animation for exit
            coverSection.style.transition = 'transform 1.2s cubic-bezier(0.7, 0, 0.3, 1), opacity 0.8s ease-out';
            coverSection.style.transform = 'translateY(-100%) scale(0.9)';
            coverSection.style.opacity = '0';

            // Allow scrolling on body if it was locked
            document.body.style.overflow = 'auto';
        });
    }

    // 2. Parallax Effect on Mouse Move
    if (container) {
        container.addEventListener('mousemove', function (e) {
            const x = (e.clientX / window.innerWidth - 0.5) * 20; // range -10 to 10
            const y = (e.clientY / window.innerHeight - 0.5) * 20;

            // Move flowers slightly
            document.querySelectorAll('.flower-sway, .flower-rise').forEach(el => {
                const speed = 0.5;
                el.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
            });

            // Move text slightly in opposite direction for depth
            document.querySelectorAll('.text-center').forEach(el => {
                const speed = -0.2;
                el.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
            });
        });

        // Reset on leave
        container.addEventListener('mouseleave', function () {
            document.querySelectorAll('.flower-sway, .flower-rise, .text-center').forEach(el => {
                el.style.transform = '';
            });
        });
    }
});
