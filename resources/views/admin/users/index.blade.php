@extends('admin.layouts.app')

@section('title', 'Users Management')

@section('content')

    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Users Management</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola data pengguna, status akun, dan reset password.</p>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 mb-6">
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                    placeholder="Cari user (Nama, Email, HP)...">
            </div>

            <div class="w-full md:w-48">
                <select name="status" onchange="this.form.submit()"
                    class="block w-full pl-3 pr-10 py-2.5 text-base border-slate-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-xl">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Stats</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold shrink-0">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-slate-900">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                        @if($user->phone)
                                            <div class="text-xs text-slate-400 mt-0.5">{{ $user->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->status === 'active')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                        Active
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800">
                                        Suspended
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col text-sm text-slate-600 gap-1">
                                    <span class="flex items-center gap-1.5" title="Total Undangan">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $user->invitations_count }} Invitations
                                    </span>
                                    <span class="flex items-center gap-1.5" title="Total Transaksi">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                        {{ $user->orders_count }} Orders
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button onclick="openUserModal({{ $user->id }})"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-800 bg-white border border-blue-200 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition shadow-sm">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                Tidak ada user ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $users->links() }}
        </div>
    </div>

    <!-- USER DETAIL MODAL -->
    <dialog id="modal-user"
        class="modal m-auto rounded-2xl shadow-2xl p-0 w-full max-w-4xl backdrop:bg-slate-900/40 backdrop:backdrop-blur-[2px]">
        <div class="bg-white flex flex-col h-auto max-h-[90vh]">
            <!-- Header -->
            <div
                class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-start sticky top-0 bg-white z-10">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight" id="modal-user-name">User Detail</h3>
                    <p class="text-sm text-slate-500" id="modal-user-email">email@example.com</p>
                </div>
                <button onclick="document.getElementById('modal-user').close()"
                    class="text-slate-400 hover:text-slate-600 p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-8 overflow-y-auto" id="modal-user-content">
                <!-- Loading State -->
                <div id="user-loading" class="flex justify-center py-10">
                    <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>

                <div id="user-data" class="hidden space-y-8">
                    <!-- Info Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-xs font-semibold text-slate-500 uppercase">HP / WhatsApp</span>
                            <div class="text-slate-900 font-bold mt-1" id="user-phone">-</div>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-xs font-semibold text-slate-500 uppercase">Total Transaksi</span>
                            <div class="text-emerald-600 font-bold mt-1">Rp <span id="user-spent">0</span></div>
                        </div>
                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                            <span class="text-xs font-semibold text-slate-500 uppercase">Bergabung</span>
                            <div class="text-slate-900 font-bold mt-1" id="user-joined">-</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Recent Invitations -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wide mb-3 border-b pb-2">
                                Invitations Terbaru</h4>
                            <ul class="space-y-3" id="list-invitations">
                                <!-- JS Injection -->
                            </ul>
                        </div>

                        <!-- Recent Orders -->
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wide mb-3 border-b pb-2">Order
                                History</h4>
                            <ul class="space-y-3" id="list-orders">
                                <!-- JS Injection -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-8 py-5 border-t border-slate-100 bg-slate-50 flex justify-between gap-3 sticky bottom-0">
                <button id="btn-reset-password" class="text-sm text-slate-600 hover:text-blue-600 underline">
                    Reset Password
                </button>

                <form id="form-user-status" method="POST" class="flex gap-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" id="input-status-value">

                    <button type="submit" id="btn-suspend"
                        class="hidden px-5 py-2.5 text-sm font-bold text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-sm transition">
                        Suspend User
                    </button>
                    <button type="submit" id="btn-activate"
                        class="hidden px-5 py-2.5 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm transition">
                        Activate User
                    </button>
                </form>
            </div>
        </div>
    </dialog>

    <script>
        function openUserModal(id) {
            const modal = document.getElementById('modal-user');
            const loader = document.getElementById('user-loading');
            const content = document.getElementById('user-data');

            // Reset View
            modal.showModal();
            loader.classList.remove('hidden');
            content.classList.add('hidden');

            // Fetch
            fetch(`/admin/users/${id}`)
                .then(res => res.json())
                .then(data => {
                    // Populate Header
                    document.getElementById('modal-user-name').innerText = data.name;
                    document.getElementById('modal-user-email').innerText = data.email;
                    document.getElementById('user-phone').innerText = data.phone || '-';
                    document.getElementById('user-spent').innerText = data.total_spent;
                    document.getElementById('user-joined').innerText = data.formatted_created_at;

                    // Status Buttons
                    const form = document.getElementById('form-user-status');
                    form.action = `/admin/users/${id}`;

                    if (data.status === 'active') {
                        document.getElementById('btn-suspend').classList.remove('hidden');
                        document.getElementById('btn-activate').classList.add('hidden');
                        document.getElementById('input-status-value').value = 'suspended';
                    } else {
                        document.getElementById('btn-suspend').classList.add('hidden');
                        document.getElementById('btn-activate').classList.remove('hidden');
                        document.getElementById('input-status-value').value = 'active';
                    }

                    // Reset Password Handler
                    document.getElementById('btn-reset-password').onclick = function () {
                        if (confirm('Generate password baru untuk user ini?')) {
                            fetch(`/admin/users/${id}/reset-password`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            })
                                .then(r => r.json())
                                .then(res => {
                                    prompt('Password baru (Copy sekarang, tidak akan muncul lagi):', res.new_password);
                                });
                        }
                    };

                    // Invitations
                    const invList = document.getElementById('list-invitations');
                    invList.innerHTML = '';
                    if (data.invitations.length === 0) {
                        invList.innerHTML = '<li class="text-sm text-slate-400 italic">Belum membuat undangan</li>';
                    } else {
                        data.invitations.forEach(inv => {
                            const statusColor = inv.status === 'published' ? 'text-emerald-600 bg-emerald-50' : 'text-amber-600 bg-amber-50';
                            invList.innerHTML += `
                                <li class="bg-white border border-slate-200 rounded-lg p-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-bold text-slate-800 text-sm">${inv.title}</div>
                                            <div class="text-xs text-slate-500 font-mono mt-0.5">${inv.slug}</div>
                                        </div>
                                        <span class="text-[10px] uppercase font-bold px-2 py-0.5 rounded ${statusColor}">${inv.status}</span>
                                    </div>
                                </li>
                            `;
                        });
                    }

                    // Orders
                    const ordList = document.getElementById('list-orders');
                    ordList.innerHTML = '';
                    if (data.orders.length === 0) {
                        ordList.innerHTML = '<li class="text-sm text-slate-400 italic">Belum ada order</li>';
                    } else {
                        data.orders.forEach(ord => {
                            const statusColor = ord.payment_status === 'paid' ? 'text-emerald-600' : 'text-slate-500';
                            ordList.innerHTML += `
                                 <li class="flex justify-between items-center text-sm border-b border-slate-50 pb-2 last:border-0">
                                    <div>
                                        <div class="font-semibold text-slate-700">${ord.package.name}</div>
                                        <div class="text-xs text-slate-400">Rp ${Number(ord.amount).toLocaleString('id-ID')}</div>
                                    </div>
                                    <span class="font-bold text-xs uppercase ${statusColor}">${ord.payment_status}</span>
                                </li>
                            `;
                        });
                    }

                    // Show Content
                    loader.classList.add('hidden');
                    content.classList.remove('hidden');
                });
        }
    </script>

@endsection