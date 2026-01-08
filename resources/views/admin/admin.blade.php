<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wanderlust - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-indigo-900 text-white flex-shrink-0">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-8">
                    <div class="bg-white p-2 rounded-lg">
                        <i class="fas fa-map-marked-alt text-indigo-900 text-xl"></i>
                    </div>
                    <span class="text-xl font-bold tracking-wider">WANDERLUST</span>
                </div>
                
                <nav class="space-y-1">
                    <a href="?page=dashboard" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ $page == 'dashboard' ? 'bg-indigo-800' : 'hover:bg-indigo-800/50' }}">
                        <i class="fas fa-chart-line w-5"></i> Dashboard
                    </a>
                    <a href="?page=users" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ $page == 'users' ? 'bg-indigo-800' : 'hover:bg-indigo-800/50' }}">
                        <i class="fas fa-users w-5"></i> Wisatawan
                    </a>
                    <a href="?page=wisata" class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ ($page == 'wisata' || $page == 'review_detail') ? 'bg-indigo-800' : 'hover:bg-indigo-800/50' }}">
                        <i class="fas fa-map-pin w-5"></i> Destinasi Wisata
                    </a>
                </nav>
            </div>

            <div class="absolute bottom-0 w-64 p-6 bg-indigo-950">
                <div class="flex items-center gap-3">
                    {{-- Sesuaikan: Kalau di DB kolomnya 'foto', pastikan terpanggil --}}
                    <img src="{{ $user->foto ?? 'https://ui-avatars.com/api/?name=' . ($user->name ?? 'Admin') }}" class="w-10 h-10 rounded-full border-2 border-indigo-400 object-cover">
                    <div class="overflow-hidden">
                        <p class="text-sm font-semibold truncate">{{ $user->name ?? 'Admin Riska' }}</p>
                        <a href="?page=profile" class="text-xs text-indigo-300 hover:text-white transition">Edit Profil</a>
                    </div>
                </div>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm px-8 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">
                    @if($page == 'dashboard') Dashboard Overview
                    @elseif($page == 'users') Manajemen Wisatawan
                    @elseif($page == 'wisata') Review Destinasi Wisata
                    @elseif($page == 'review_detail') Detail Review Wisata
                    @elseif($page == 'profile') Pengaturan Profil
                    @endif
                </h2>
                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-400 hover:text-indigo-600">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    {{-- Logout logic --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-600 font-medium px-4 py-2 rounded-lg hover:bg-red-50 transition">
                            Keluar <i class="fas fa-sign-out-alt ml-1"></i>
                        </button>
                    </form>
                </div>
            </header>

            <div class="p-8">
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3"></i>
                        {{ session('success') }}
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-700">&times;</button>
                </div>
                @endif

                @if($page == 'dashboard')
                    {{-- TAMPILAN DASHBOARD --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Total Wisatawan</p>
                                    <h3 class="text-2xl font-bold">{{ count($users) }}</h3>
                                </div>
                                <div class="bg-blue-50 p-3 rounded-lg text-blue-600">
                                    <i class="fas fa-users text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Destinasi Aktif</p>
                                    <h3 class="text-2xl font-bold">{{ $wisatas->where('status', 'approved')->count() }}</h3>
                                </div>
                                <div class="bg-green-50 p-3 rounded-lg text-green-600">
                                    <i class="fas fa-map-marked-alt text-xl"></i>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Menunggu Review</p>
                                    <h3 class="text-2xl font-bold">{{ $wisatas->where('status', 'pending')->count() }}</h3>
                                </div>
                                <div class="bg-orange-50 p-3 rounded-lg text-orange-600">
                                    <i class="fas fa-clock text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4">Tren Kunjungan Wisatawan</h3>
                        <canvas id="visitorChart" height="100"></canvas>
                    </div>

                @elseif($page == 'users')
                    {{-- TAMPILAN KELOLA USER/WISATAWAN --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Daftar Wisatawan Terdaftar</h3>
                            <button onclick="document.getElementById('modalUser').classList.remove('hidden')" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                                <i class="fas fa-plus mr-2"></i> Tambah Wisatawan
                            </button>
                        </div>
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-600 text-sm uppercase">
                                <tr>
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Nama</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-gray-700">
                                @forelse($users as $u)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium">#{{ $u->id }}</td>
                                    {{-- SESUAIKAN: Kalau di DB kolomnya 'nama', tetap $u->nama --}}
                                    <td class="px-6 py-4">{{ $u->nama }}</td> 
                                    <td class="px-6 py-4">{{ $u->email }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ ($u->status == 'AKTIF' || $u->status == 'aktif') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ strtoupper($u->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <form action="{{ route('admin.toggle', $u->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button class="p-2 text-indigo-600 hover:bg-indigo-50 rounded" title="Ubah Status">
                                                    <i class="fas fa-sync-alt"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus ini?')">
                                                @csrf @method('DELETE')
                                                <button class="p-2 text-red-600 hover:bg-red-50 rounded">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="p-6 text-center text-gray-500">Belum ada data di database wanderlust.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                @elseif($page == 'wisata')
                    {{-- TAMPILAN KELOLA WISATA (Cards) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($wisatas as $w)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                            <div class="h-48 bg-gray-200 relative">
                                <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80&sig={{ $w->id }}" class="w-full h-full object-cover">
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase shadow-sm
                                        {{ $w->status == 'approved' ? 'bg-green-500 text-white' : ($w->status == 'pending' ? 'bg-orange-500 text-white' : 'bg-gray-500 text-white') }}">
                                        {{ $w->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                {{-- SESUAIKAN: Nama Kolom di Tabel tempat_wisatas --}}
                                <h4 class="font-bold text-lg text-gray-800 mb-1">{{ $w->nama_wisata }}</h4>
                                <p class="text-sm text-gray-500 mb-4 flex items-center">
                                    <i class="fas fa-user-circle mr-2"></i> Pemilik: {{ $w->pemilik }}
                                </p>
                                <a href="?page=review_detail&id={{ $w->id }}" class="block text-center bg-gray-100 text-gray-700 py-2 rounded-lg font-semibold hover:bg-indigo-600 hover:text-white transition">
                                    Lihat Detail & Review
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-12 text-gray-500">Belum ada data di tabel tempat_wisatas.</div>
                        @endforelse
                    </div>

                @elseif($page == 'review_detail' && isset($wisata_single))
                    {{-- TAMPILAN DETAIL REVIEW --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="md:flex">
                            <div class="md:w-1/2">
                                <img src="https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover">
                            </div>
                            <div class="md:w-1/2 p-10">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase">Review Destinasi</span>
                                    <span class="text-gray-400">•</span>
                                    <span class="text-gray-500 text-sm">ID: #{{ $wisata_single->id }}</span>
                                </div>
                                <h3 class="text-3xl font-bold text-gray-800 mb-4">{{ $wisata_single->nama_wisata }}</h3>
                                <div class="space-y-4 mb-8">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Pemilik</p>
                                        <p class="text-gray-700 font-medium">{{ $wisata_single->pemilik }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Deskripsi Destinasi</p>
                                        <p class="text-gray-600 leading-relaxed">{{ $wisata_single->deskripsi }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Status Saat Ini</p>
                                        <span class="inline-block mt-1 px-4 py-1 rounded-full text-sm font-bold uppercase {{ $wisata_single->status == 'approved' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                            {{ $wisata_single->status }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-4 border-t pt-8">
                                    <form action="{{ route('wisata.approve', $wisata_single->id) }}" method="POST" class="flex-1">
                                        @csrf @method('PATCH')
                                        <button class="w-full bg-green-600 text-white py-3 rounded-xl font-bold hover:bg-green-700 shadow-lg transition">
                                            <i class="fas fa-check-circle mr-2"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('wisata.revisi', $wisata_single->id) }}" method="POST" class="flex-1">
                                        @csrf @method('PATCH')
                                        <button class="w-full bg-white border-2 border-orange-500 text-orange-600 py-3 rounded-xl font-bold hover:bg-orange-50 transition">
                                            <i class="fas fa-undo mr-2"></i> Minta Revisi
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @elseif($page == 'profile')
                    {{-- TAMPILAN PROFIL --}}
                    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                        <div class="text-center mb-8">
                            <div class="relative inline-block">
                                <img src="{{ $user->foto ?? 'https://ui-avatars.com/api/?name=' . ($user->name ?? 'Admin') }}" class="w-32 h-32 rounded-full border-4 border-indigo-50 shadow-md mx-auto mb-4 object-cover">
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $user->name ?? 'Admin Riska' }}</h3>
                            <p class="text-gray-500 italic">"{{ $user->bio ?? 'Halo admin!' }}"</p>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                            @csrf @method('PATCH')
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Bio</label>
                                <textarea name="bio" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-indigo-500 outline-none">{{ $user->bio }}</textarea>
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold hover:bg-indigo-700 transition">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </main>
    </div>

    <div id="modalUser" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full max-w-md p-8 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold">Tambah Wisatawan Baru</h3>
                <button onclick="document.getElementById('modalUser').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            <form action="{{ route('admin.storeUser') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Nama</label>
                    <input type="text" name="nama" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-bold hover:bg-indigo-700 transition mt-4">
                    Simpan Data
                </button>
            </form>
        </div>
    </div>

    @if($page == 'dashboard')
    <script>
        const ctx = document.getElementById('visitorChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pengunjung',
                    data: {!! json_encode($chartData) !!},
                    borderColor: 'rgb(79, 70, 229)',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } }
            }
        });
    </script>
    @endif
</body>
</html>