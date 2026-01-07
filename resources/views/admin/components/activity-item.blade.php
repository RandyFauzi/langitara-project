@props(['log'])

<div class="flex space-x-3 py-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors px-4 -mx-4">
    <div class="flex-shrink-0">
        <span class="h-10 w-10 rounded-full bg-slate-100 flex items-center justify-center ring-4 ring-white">
            <!-- Simple conditional icon based on internal logic if needed, else generic -->
            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </span>
    </div>
    <div class="min-w-0 flex-1">
        <p class="text-sm font-medium text-gray-900">
            {{ $log->actor_type }}
            <span class="text-gray-500 font-normal">performed</span>
            {{ $log->action }}
        </p>
        <p class="text-sm text-gray-500">
            {{ $log->formatted_date }}
        </p>
    </div>
    <div>
        <!-- Status indicator dot if needed -->
    </div>
</div>