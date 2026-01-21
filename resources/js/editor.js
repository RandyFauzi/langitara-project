import axios from 'axios';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Define Editor Function globally
// Define Editor Function globally
window.editor = function (invitationId, invitationSlug, initialTemplateId) {
    return {
        invitationId,
        invitationSlug,

        loading: true,
        saving: false,
        dirty: false,
        activeTab: 'edit',
        activeMenu: 'meta', // Default to 'meta' to match sidebar first item

        // Sections Config (Required for Sidebar/Mobile Menu)
        sections: [
            { id: 'template', label: 'Pilih Tema', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" /></svg>' },
            { id: 'meta', label: 'General Info', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' },
            { id: 'couple', label: 'Bride & Groom', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>' },
            { id: 'events', label: 'Events', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>' },
            { id: 'location', label: 'Location', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>' },
            { id: 'album', label: 'Gallery', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>' },
            { id: 'story', label: 'Love Story', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>' },
            { id: 'music', label: 'Music', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" /></svg>' },
            { id: 'guests', label: 'Guest List', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>' },
            { id: 'gift', label: 'Gift', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" /></svg>' },
            { id: 'rsvp', label: 'RSVP', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>' },
            { id: 'closing', label: 'Closing', icon: '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" /></svg>' }
        ],

        // ✅ WAJIB ADA DEFAULT SHAPE
        form: {
            template_id: initialTemplateId,
            meta: {
                title: '',
                description: '',
            },

            album: { // Was gallery
                enabled: true,
                title: '',
                description: '',
                layout: 'slide',
                items: [], // Was photos
            },

            story: {
                enabled: true,
                layout: 'slider',
                items: [],
            },

            closing: {
                text: '',
                invitees: '', // Was invited_by
                note: '',
            },

            guests: [],

            rsvp: {
                enabled: true,
                max_pax: 1,
                note: '',
            },

            gift: {
                enabled: false,
                layout: 'floating',
                title: '',
                note: '',
                items: [], // Was accounts
            },

            couple: {
                bride: {}, groom: {}
            },

            events: [],

            location: {},

            music: {},

            settings: {
                music: null,
                language: 'id',
            },

            extra: {
                custom_domain: null,
            },
        },

        errors: {},
        isMobile: window.innerWidth < 768,

        get currentSectionLabel() {
            return this.sections.find(s => s.id === this.activeMenu)?.label || 'Edit';
        },

        init() {
            this.loadPayload();
            this.$watch('activeMenu', (value) => {
                // Sync URL
                const url = new URL(window.location);
                url.searchParams.set('form', value);
                window.history.pushState({}, '', url);
            });
            window.addEventListener('resize', () => {
                this.isMobile = window.innerWidth < 768;
            });
        },

        loadPayload() {
            // Because we have default state, we can use async fetch safely
            axios.get(`/admin/editor/invitations/${this.invitationId}`)
                .then(res => {
                    const data = res.data.data;
                    if (!data) return;

                    // merge payload tanpa merusak default shape
                    // Note: Backend returns 'form' object directly now based on previous refactor
                    // We need to match keys.
                    // The keys in 'data.form' from previous step were: meta, couple, events, album, story, closing, location...
                    // Our default shape uses: meta, album, story, closing, guests, rsvp, gift...

                    // We must ensure backend keys map to these keys.
                    // The previous Service update ALREADY uses 'album', 'story' keys.
                    // So we can merge safely.

                    this.form = {
                        ...this.form,
                        ...data.form
                    };
                })
                .catch(err => {
                    console.error(err);
                    alert('Error loading data');
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        // Helpers
        sectionHasError(id) { return false; }, // Placeholder
        uploadImage: async function (file) {
            const formData = new FormData();
            formData.append('file', file);
            try {
                const res = await axios.post('/admin/editor/media/upload', formData, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                });
                return res.data.url;
            } catch (e) { return null; }
        },
        moveItem(path, index, direction) {
            // Simple resolver for common paths
            let arr = null;
            if (path === 'events') arr = this.form.events;
            if (path === 'album.items') arr = this.form.album.items;
            if (path === 'story.items') arr = this.form.story.items;
            if (path === 'guests') arr = this.form.guests;

            if (arr && arr[index + direction]) {
                const temp = arr[index];
                arr[index] = arr[index + direction];
                arr[index + direction] = temp;
            }
        },
        addEvent() {
            this.form.events.push({});
        },
        removeEvent(index) {
            this.form.events.splice(index, 1);
        },
        addGalleryItem(url) {
            this.form.album.items.push({ url: url });
        },
        removeGalleryItem(index) {
            this.form.album.items.splice(index, 1);
        },
        addLoveStory() {
            this.form.story.items.push({ year: '2024' });
        },
        removeLoveStory(index) {
            this.form.story.items.splice(index, 1);
        },
        addGuest() {
            this.form.guests.unshift({ name: 'New Guest', pax: 1, category: 'Umum' });
        },
        removeGuest(index) {
            this.form.guests.splice(index, 1);
        }
    }
}

document.addEventListener('alpine:init', () => {
    // Alpine.data('editor') is NOT needed if we used window.editor directly in x-data="editor()"
    // But x-data="editor()" expects a function on window.
    // Done.
});

Alpine.start();
