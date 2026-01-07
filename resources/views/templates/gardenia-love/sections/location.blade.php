<section id="location" class="py-0 bg-[#FDFBF7]">
    <div class="w-full h-96 bg-slate-200 grayscale hover:grayscale-0 transition duration-700">
        <!-- Embedded Map Iframe -->
        <!-- In production, this would be dynamic based on user input coordinates or link -->
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126915.06649735954!2d106.75709564619472!3d-6.246473436043138!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3c772dbda0d%3A0x77c44243d463273e!2sHotel%20Mulia%20Senayan%20Jakarta!5e0!3m2!1sen!2sid!4v1709795000000!5m2!1sen!2sid"
            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    <div class="px-6 py-6 bg-white text-center">
        <p class="text-sm font-semibold text-slate-800">{{ $location_name ?? 'Location Name' }}</p>
        <p class="text-xs text-slate-500 mt-1">{{ $location_address ?? 'Full Address Here' }}</p>
    </div>
</section>