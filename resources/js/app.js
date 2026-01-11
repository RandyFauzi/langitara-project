import './bootstrap';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.Alpine = Alpine;

Alpine.plugin(collapse);
Alpine.start();

// Initialize Animate On Scroll
document.addEventListener('DOMContentLoaded', () => {
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        mirror: false,
        offset: 50,
    });
});
