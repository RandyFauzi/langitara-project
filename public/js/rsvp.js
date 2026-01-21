
document.addEventListener('DOMContentLoaded', () => {
    const rsvpForm = document.getElementById('rsvp-form');

    if (rsvpForm) {
        rsvpForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            // 1. Gather Data
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');

            // Disable button to prevent double submit
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Menyimpan...';

            try {
                // 2. Fetch API
                const response = await fetch('/rsvp', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const result = await response.json();

                // 3. Handle Response
                if (response.ok && result.success) {
                    // Success Alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Terima Kasih!',
                        text: result.message,
                        confirmButtonColor: '#8B4513' // Adjust to theme color
                    }).then(() => {
                        // Optional: Reload or Update UI
                        // window.location.reload();
                    });

                    // Reset form
                    rsvpForm.reset();

                } else {
                    // Validation or Server Error
                    throw new Error(result.message || 'Terjadi kesalahan.');
                }

            } catch (error) {
                console.error('RSVP Error:', error);

                let errorMessage = error.message;

                // Handle Validation Errors Object
                if (error.errors) {
                    errorMessage = Object.values(error.errors).flat().join('\n');
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    text: errorMessage,
                    confirmButtonColor: '#d33'
                });

            } finally {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }
});
