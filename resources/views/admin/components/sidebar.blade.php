<aside class="w-64 bg-slate-50 border-r border-gray-200 fixed h-full hidden md:flex flex-col z-30">
    <!-- Brand -->
    <a href="{{ route('admin.dashboard') }}"
        class="h-16 flex items-center px-6 border-b border-gray-200 bg-white hover:bg-slate-50 transition">
        <img src="{{ asset('images/logo.png') }}" alt="Langitara Logo" class="h-10 w-auto">
    </a>

    <!-- Menu -->
    <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1">

        <!-- Dashboard (Active) -->
        <a href="{{ route('admin.dashboard') }}"
            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg bg-rose-50 text-rose-700">
            <svg class="mr-3 flex-shrink-0 h-5 w-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            Dashboard
        </a>



        <!-- Orders -->
        <!-- Orders -->
        <a href="{{ route('admin.orders.index') }}"
            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.orders*') ? 'bg-rose-50 text-rose-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('admin.orders*') ? 'text-rose-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            Orders
        </a>

        <!-- Packages -->
        <a href="{{ route('admin.packages.index') }}"
            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.packages*') ? 'bg-rose-50 text-rose-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('admin.packages*') ? 'text-rose-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            Paket Layanan
        </a>

        <!-- Promos -->
        <a href="{{ route('admin.promos.index') }}"
            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.promos*') ? 'bg-rose-50 text-rose-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('admin.promos*') ? 'text-rose-600' : 'text-gray-400 group-hover:text-gray-500' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Promos & Campaigns
        </a>

        <!-- Users -->
        <a href="{{ route('admin.users.index') }}"
            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.users*') ? 'bg-rose-50 text-rose-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('admin.users*') ? 'text-rose-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
            Users
        </a>

        <!-- Templates -->
        <a href="{{ route('admin.templates.index') }}"
            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.templates.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('admin.templates.*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                </path>
            </svg>
            Templates
        </a>

        <!-- Music Library -->
        <a href="{{ route('admin.songs.index') }}"
            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.songs*') ? 'bg-amber-50 text-amber-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('admin.songs*') ? 'text-amber-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2z">
                </path>
            </svg>
            Music Library
        </a>

        <!-- Invitations -->
        <a href="{{ route('admin.invitations.index') }}"
            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('admin.invitations*') ? 'bg-rose-50 text-rose-700' : 'text-gray-700 hover:text-gray-900 hover:bg-gray-100' }}">
            <svg class="mr-3 flex-shrink-0 h-5 w-5 {{ request()->routeIs('admin.invitations*') ? 'text-rose-600' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
            </svg>
            Invitations
        </a>



        <!-- Logs -->
        <a href="{{ route('admin.activity-logs.index') }}"
            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg text-gray-700 hover:text-gray-900 hover:bg-gray-100">
            <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-500" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Activity Logs
        </a>
    </nav>

    <!-- Bottom User -->
    <div class="p-4 border-t border-gray-200">
        <a href="#" class="flex flex-shrink-0 group block">
            <div class="flex items-center">
                <div
                    class="inline-block h-9 w-9 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 font-bold">
                    A
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Admin</p>
                    <p class="text-xs font-medium text-gray-500 group-hover:text-gray-700">View Profile</p>
                </div>
            </div>
        </a>
    </div>
</aside>