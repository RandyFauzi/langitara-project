document.addEventListener('DOMContentLoaded', function () {
    const openBtn = document.getElementById('open-invitation');
    const coverSection = document.getElementById('cover-section');

    if (openBtn && coverSection) {
        openBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // Option 1: Scroll to next section
            // const nextSection = coverSection.nextElementSibling;
            // if (nextSection) {
            //     nextSection.scrollIntoView({ behavior: 'smooth' });
            // }

            // Option 2: Hide cover (common in invitation templates)
            coverSection.classList.add('transition-transform', 'duration-1000', '-translate-y-full');

            // Allow scrolling on body if it was locked
            document.body.style.overflow = 'auto';
        });
    }
});
