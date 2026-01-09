<div class="space-y-8">

    <!-- Bride -->
    <div>
        <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <span class="text-pink-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </span>
            The Bride
        </h3>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm grid gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nickname <span
                        class="text-red-500">*</span></label>
                <input type="text" x-model="form.couple.bride.name"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    placeholder="e.g. Juliet">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                <input type="text" x-model="form.couple.bride.full_name"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    placeholder="e.g. Juliet Rose Capulet">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Parents Name</label>
                <textarea x-model="form.couple.bride.parents" rows="2"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    placeholder="Daughter of Mr..."></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Instagram (@username)</label>
                    <input type="text" x-model="form.couple.bride.instagram"
                        class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Photo URL</label>
                    <div class="flex gap-2">
                        <input type="text" x-model="form.couple.bride.photo"
                            class="flex-1 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                        <label
                            class="cursor-pointer px-3 py-2 bg-slate-100 border border-slate-300 rounded-lg hover:bg-slate-200 transition">
                            <span class="text-xs font-medium text-slate-600">Upload</span>
                            <input type="file" class="hidden" accept="image/*"
                                @change="uploadImage($event.target.files[0]).then(url => { if(url) form.couple.bride.photo = url })">
                        </label>
                    </div>
                    <template x-if="form.couple.bride?.photo">
                        <img :src="form.couple.bride.photo"
                            class="mt-2 w-20 h-20 object-cover rounded-lg border border-slate-200">
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Groom -->
    <div>
        <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
            <span class="text-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </span>
            The Groom
        </h3>
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm grid gap-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nickname <span
                        class="text-red-500">*</span></label>
                <input type="text" x-model="form.couple.groom.name"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    placeholder="e.g. Romeo">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                <input type="text" x-model="form.couple.groom.full_name"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    placeholder="e.g. Romeo Montague">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Parents Name</label>
                <textarea x-model="form.couple.groom.parents" rows="2"
                    class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    placeholder="Son of Mr..."></textarea>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Instagram (@username)</label>
                    <input type="text" x-model="form.couple.groom.instagram"
                        class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Photo URL</label>
                    <div class="flex gap-2">
                        <input type="text" x-model="form.couple.groom.photo"
                            class="flex-1 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                        <label
                            class="cursor-pointer px-3 py-2 bg-slate-100 border border-slate-300 rounded-lg hover:bg-slate-200 transition">
                            <span class="text-xs font-medium text-slate-600">Upload</span>
                            <input type="file" class="hidden" accept="image/*"
                                @change="uploadImage($event.target.files[0]).then(url => { if(url) form.couple.groom.photo = url })">
                        </label>
                    </div>
                    <template x-if="form.couple.groom?.photo">
                        <img :src="form.couple.groom.photo"
                            class="mt-2 w-20 h-20 object-cover rounded-lg border border-slate-200">
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>