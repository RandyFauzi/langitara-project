@props(['invitation', 'guest' => null])

<div class="w-full max-w-lg mx-auto bg-white/30 backdrop-blur-md border border-white/20 rounded-xl shadow-lg overflow-hidden">
    <div class="p-6">
        <h3 class="text-xl font-serif text-gray-800 text-center mb-6">Konfirmasi Kehadiran</h3>

        <form id="rsvp-form" class="space-y-4">
            {{-- Hidden Inputs --}}
            <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">
            @if($guest)
                <input type="hidden" name="guest_id" value="{{ $guest->id }}">
            @endif

            {{-- Guest Name --}}
            <div>
                <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Tamu</label>
                <input type="text" 
                       id="guest_name" 
                       name="guest_name" 
                       value="{{ $guest ? $guest->name : '' }}" 
                       class="w-full px-4 py-2 bg-white/50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-transparent outline-none transition disabled:bg-gray-100 disabled:text-gray-500"
                       placeholder="Masukkan nama Anda"
                       {{ $guest ? 'readonly' : 'required' }}>
            </div>

            {{-- Presence Status --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Apakah Anda akan hadir?</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="cursor-pointer">
                        <input type="radio" name="presence_status" value="hadir" class="peer sr-only" required>
                        <div class="text-center py-2 rounded-lg border border-gray-300 bg-white/50 peer-checked:bg-green-100 peer-checked:border-green-500 peer-checked:text-green-700 transition hover:bg-white/80">
                            Hadir
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="presence_status" value="tidak" class="peer sr-only">
                        <div class="text-center py-2 rounded-lg border border-gray-300 bg-white/50 peer-checked:bg-red-100 peer-checked:border-red-500 peer-checked:text-red-700 transition hover:bg-white/80">
                            Maaf
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="presence_status" value="ragu" class="peer sr-only">
                        <div class="text-center py-2 rounded-lg border border-gray-300 bg-white/50 peer-checked:bg-yellow-100 peer-checked:border-yellow-500 peer-checked:text-yellow-700 transition hover:bg-white/80">
                            Ragu
                        </div>
                    </label>
                </div>
            </div>

            {{-- Total Guests --}}
            <div>
                <label for="total_guests" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tamu (Maks. 5)</label>
                <select id="total_guests" name="total_guests" class="w-full px-4 py-2 bg-white/50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-transparent outline-none transition">
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} Orang</option>
                    @endfor
                </select>
            </div>

            {{-- Message --}}
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Ucapan & Doa</label>
                <textarea id="message" 
                          name="message" 
                          rows="3" 
                          class="w-full px-4 py-2 bg-white/50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brown-400 focus:border-transparent outline-none transition"
                          placeholder="Tuliskan ucapan selamat..."></textarea>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="w-full py-2.5 bg-gray-800 text-white font-medium rounded-lg hover:bg-gray-900 focus:ring-4 focus:ring-gray-300 transition transform active:scale-95">
                Kirim Konfirmasi
            </button>
        </form>
    </div>
</div>

{{-- Scripts Injection --}}
@push('scripts')
<script src="{{ asset('js/rsvp.js') }}"></script>
@endpush
