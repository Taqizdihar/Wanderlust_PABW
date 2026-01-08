<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Admin - Wanderlust</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-50 flex font-sans">

    {{-- SIDEBAR --}}
    <div class="w-72 bg-[#2D6A76] min-h-screen text-white p-6 shadow-xl fixed">
        <div class="flex items-center gap-3 mb-10">
            <div class="bg-blue-400 p-2 rounded-lg shadow-lg">
                <i class="fas fa-box text-xl text-white"></i>
            </div>
            <h1 class="text-2xl font-bold tracking-tight">Wanderlust</h1>
        </div>

        <div class="text-center mb-10">
            <img src="https://i.pravatar.cc/150?u=riska" class="w-20 h-20 rounded-full mx-auto border-4 border-[#3a828e] shadow-md object-cover">
            <p class="mt-3 font-semibold text-lg leading-none">Halo, Admin</p>
            {{-- Nama Admin dinamis dari database --}}
            <p class="text-[10px] text-gray-300 mt-2 uppercase tracking-[0.2em] font-bold">{{ $user->nama ?? 'RISKA DEA BAKRI' }}</p>
        </div>

        <nav class="space-y-2">
            <a href="{{ route('admin.index', ['page' => 'dashboard']) }}" 
               class="flex items-center gap-4 p-3 rounded-xl transition {{ $page == 'dashboard' ? 'bg-[#1e4b54] shadow-inner' : 'hover:bg-[#3a828e]' }}">
                <i class="fas fa-th-large w-5 text-center"></i> <span class="font-medium">Dashboard</span>
            </a>
            <a href="{{ route('admin.index', ['page' => 'users']) }}" 
               class="flex items-center gap-4 p-3 rounded-xl transition {{ $page == 'users' || $page == 'tambah_user' ? 'bg-[#1e4b54] shadow-inner' : 'hover:bg-[#3a828e]' }}">
                <i class="fas fa-users w-5 text-center"></i> <span class="font-medium">Kelola User</span>
            </a>
            <a href="{{ route('admin.index', ['page' => 'wisata']) }}" class="flex items-center gap-4 p-3 rounded-xl transition {{ $page == 'wisata' || $page == 'review_detail' || $page == 'tambah_wisata' ? 'bg-[#1e4b54] shadow-inner' : 'hover:bg-[#3a828e]' }}">
                <i class="fas fa-map-marked-alt w-5 text-center"></i> <span class="font-medium">Kelola Wisata</span>
            </a>
             <a href="#" class="flex items-center gap-4 p-3 rounded-xl hover:bg-[#3a828e] transition">
                <i class="fas fa-coins w-5 text-center"></i> <span class="font-medium">Kelola Keuangan</span>
            </a>
        </nav>
    </div>

    {{-- MAIN CONTENT AREA --}}
    <div class="flex-1 ml-72 flex flex-col">
        <header class="bg-[#2D6A76] text-white p-4 px-10 flex justify-between items-center sticky top-0 z-10 shadow-md">
            <h2 class="text-xl font-semibold italic">
                @if($page == 'dashboard') Dashboard Utama @elseif($page == 'users') Kelola User @elseif($page == 'tambah_user') Tambah Wisatawan @elseif($page == 'wisata') Kelola Wisata @elseif($page == 'tambah_wisata') Input Wisata Baru @elseif($page == 'review_detail') Detail Review Wisata @else Profil Admin @endif
            </h2>
            <div class="flex items-center gap-6">
                <div class="relative">
                    <input type="text" placeholder="Cari..." class="rounded-full bg-[#3a828e] border-none text-white placeholder-gray-200 px-4 py-1.5 text-sm w-64 focus:ring-2 focus:ring-white">
                    <i class="fas fa-search absolute right-4 top-2.5 text-gray-200 text-xs"></i>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="hover:text-gray-200 transition">
                        Keluar <i class="fas fa-sign-out-alt ml-1"></i>
                    </button>
                </form>
            </div>
        </header>

        <main class="p-8">
            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-xl mb-6 shadow-md flex items-center gap-3">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            {{-- PAGE DASHBOARD --}}
            @if($page == 'dashboard')
                <h1 class="text-2xl font-bold text-gray-800 mb-8 tracking-tight">Selamat Datang, Admin</h1>
                <div class="grid grid-cols-4 gap-6 mb-10">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border-b-8 border-blue-400">
                        <p class="text-gray-400 text-sm font-medium mb-1 uppercase tracking-tighter">Total Destinasi</p>
                        <h3 class="text-4xl font-black text-gray-700">{{ count($wisatas) }}</h3>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border-b-8 border-green-400">
                        <p class="text-gray-400 text-sm font-medium mb-1 uppercase tracking-tighter">Member Terdaftar</p>
                        <h3 class="text-4xl font-black text-gray-700">{{ count($users) }}</h3>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border-b-8 border-yellow-400">
                        <p class="text-gray-400 text-sm font-medium mb-1 uppercase tracking-tighter">Transaksi</p>
                        <h3 class="text-4xl font-black text-gray-700">67</h3>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border-b-8 border-red-400">
                        <p class="text-gray-400 text-sm font-medium mb-1 uppercase tracking-tighter">Estimasi</p>
                        <h3 class="text-2xl font-black text-gray-700">Rp 12.5M</h3>
                    </div>
                </div>

                {{-- DIAGRAM STATISTIK --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 mb-10">
                    <h4 class="text-lg font-bold text-gray-700 mb-6 italic"><i class="fas fa-users-cog mr-2 text-teal-600"></i> Statistik Member</h4>
                    <canvas id="comparisonChart" height="80"></canvas>
                </div>

            {{-- PAGE KELOLA USER --}}
            @elseif($page == 'users')
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Detail List Wisatawan</h1>
                    <a href="{{ route('admin.index', ['page' => 'tambah_user']) }}" class="bg-[#2D6A76] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:bg-[#1e4b54] transition">
                        <i class="fas fa-user-plus mr-2"></i> Tambah Wisatawan
                    </a>
                </div>
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 text-xs uppercase font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Nama Lengkap</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $u)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-medium text-gray-500">#00{{ $u->id_wisatawan ?? $u->id }}</td>
                                <td class="px-6 py-4 text-gray-700">
                                    <p class="font-semibold">{{ $u->nama }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $u->email }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase {{ strtolower($u->status ?? 'aktif') == 'aktif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                        {{ $u->status ?? 'AKTIF' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-2">
                                    <form action="{{ route('admin.toggle', $u->id_wisatawan ?? $u->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-yellow-50 text-yellow-600 border border-yellow-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-yellow-500 hover:text-white transition">Status</button>
                                    </form>
                                    <form action="{{ route('admin.destroy', $u->id_wisatawan ?? $u->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-red-600 hover:text-white transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-10 text-center text-gray-400 italic">Belum ada data di database wanderlust.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            {{-- PAGE TAMBAH USER --}}
            @elseif($page == 'tambah_user')
                <div class="max-w-xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-[#2D6A76] p-6 text-white text-center">
                        <h2 class="text-xl font-bold uppercase tracking-widest italic">Tambah Wisatawan Baru</h2>
                    </div>
                    <form action="{{ route('admin.storeUser') }}" method="POST" class="p-8 space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2">Nama Lengkap</label>
                            <input type="text" name="nama" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none font-bold text-gray-700" placeholder="Contoh: Budi Santoso" required>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2">Alamat Email</label>
                            <input type="email" name="email" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none font-bold text-gray-700" placeholder="budi@email.com" required>
                        </div>
                        <p class="text-[10px] text-gray-400 italic text-center">*Password otomatis diset ke: password123</p>
                        <button type="submit" class="w-full bg-[#2D6A76] text-white py-4 rounded-2xl font-black text-xs shadow-lg hover:bg-[#1e4b54] transition uppercase tracking-widest">
                            SIMPAN WISATAWAN KE DATABASE
                        </button>
                    </form>
                </div>

            {{-- PAGE KELOLA WISATA --}}
            @elseif($page == 'wisata')
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Kelola Persetujuan Wisata</h2>
                    <a href="{{ route('admin.index', ['page' => 'tambah_wisata']) }}" class="bg-[#2D6A76] text-white px-5 py-2.5 rounded-xl text-xs font-black shadow-lg hover:bg-[#1e4b54] transition uppercase tracking-widest">
                        <i class="fas fa-plus mr-2"></i> Tambah Wisata
                    </a>
                </div>
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b text-xs uppercase font-bold text-slate-500 tracking-wider">
                            <tr>
                                <th class="p-6">Nama Wisata</th>
                                <th class="p-6">Pemilik</th>
                                <th class="p-6 text-center">Status</th>
                                <th class="p-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($wisatas as $w)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-6 font-bold text-gray-800">{{ $w->nama_tempat ?? $w->nama_wisata }}</td>
                                <td class="p-6 text-slate-600 font-medium">{{ $w->pemilik ?? 'Admin' }}</td>
                                <td class="p-6 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black tracking-widest uppercase {{ ($w->status ?? 'pending') == 'pending' ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-600' }}">
                                        {{ $w->status ?? 'PENDING' }}
                                    </span>
                                </td>
                                <td class="p-6 flex justify-center gap-3">
                                    <a href="{{ route('admin.index', ['page' => 'review_detail', 'id' => ($w->id_tempat ?? $w->id)]) }}" class="bg-blue-50 text-blue-600 border border-blue-200 px-4 py-2 rounded-xl text-xs font-bold hover:bg-blue-600 hover:text-white transition">
                                        <i class="fas fa-eye mr-1"></i> Review
                                    </a>
                                    <form action="{{ route('wisata.delete', ($w->id_tempat ?? $w->id)) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-600 hover:text-white transition">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-10 text-center text-gray-400 italic">Belum ada data destinasi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            {{-- PAGE TAMBAH WISATA --}}
            @elseif($page == 'tambah_wisata')
                <div class="max-w-2xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-[#2D6A76] p-6 text-white text-center">
                        <h2 class="text-xl font-bold uppercase tracking-widest italic">Input Wisata Baru</h2>
                    </div>
                    <form action="{{ route('wisata.store') }}" method="POST" class="p-8 space-y-5">
                        @csrf
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2 tracking-widest">Nama Wisata</label>
                            <input type="text" name="nama_wisata" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none font-bold text-gray-700" placeholder="Contoh: Pantai Pangandaran" required>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2 tracking-widest">Nama Pemilik</label>
                            <input type="text" name="pemilik" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none font-bold text-gray-700" placeholder="Riska Dea" required>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-gray-400 uppercase mb-2 tracking-widest">Deskripsi Wisata</label>
                            <textarea name="deskripsi" rows="5" class="w-full px-4 py-3 rounded-xl border border-gray-200 outline-none font-medium text-gray-600 leading-relaxed" placeholder="Tuliskan deskripsi lengkap di sini..." required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-[#2D6A76] text-white py-4 rounded-2xl font-black text-xs shadow-lg hover:bg-[#1e4b54] transition uppercase tracking-[0.3em]">
                            SIMPAN DATA KE DATABASE
                        </button>
                    </form>
                </div>

            {{-- PAGE DETAIL REVIEW --}}
            @elseif($page == 'review_detail' && $wisata_single)
                <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-[#2D6A76] p-8 text-white flex justify-between items-center">
                        <div>
                            <p class="text-[10px] uppercase tracking-[0.3em] font-bold opacity-70 mb-1">Moderasi Wisata</p>
                            <h2 class="text-2xl font-bold italic">{{ $wisata_single->nama_tempat ?? $wisata_single->nama_wisata }}</h2>
                        </div>
                        <a href="{{ route('admin.index', ['page' => 'wisata']) }}" class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl text-xs font-bold transition">
                            <i class="fas fa-arrow-left mr-2"></i> KEMBALI
                        </a>
                    </div>
                    <div class="p-10 grid grid-cols-2 gap-10">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?w=500" class="rounded-3xl w-full h-80 object-cover shadow-2xl border-8 border-gray-50">
                        <div class="space-y-6">
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Wisata</label>
                                <p class="text-xl font-bold text-gray-700 leading-none">{{ $wisata_single->nama_tempat ?? $wisata_single->nama_wisata }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pemilik Wisata</label>
                                <p class="text-gray-700 font-medium">{{ $wisata_single->pemilik ?? 'Admin' }}</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Deskripsi Lengkap</label>
                                <p class="text-gray-600 text-sm leading-relaxed text-justify">{{ $wisata_single->deskripsi }}</p>
                            </div>
                            <div class="flex gap-4 pt-4">
                                <form action="{{ route('wisata.approve', ($wisata_single->id_tempat ?? $wisata_single->id)) }}" method="POST" class="flex-1">
                                    @csrf @method('PATCH')
                                    <button class="w-full bg-emerald-500 text-white py-4 rounded-2xl font-black text-xs shadow-lg hover:bg-emerald-600 transition uppercase tracking-widest">Approve</button>
                                </form>
                                <form action="{{ route('wisata.revisi', ($wisata_single->id_tempat ?? $wisata_single->id)) }}" method="POST" class="flex-1">
                                    @csrf @method('PATCH')
                                    <button class="w-full bg-yellow-500 text-white py-4 rounded-2xl font-black text-xs shadow-lg hover:bg-yellow-600 transition uppercase tracking-widest">Revisi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>

    {{-- SCRIPT DIAGRAM --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('comparisonChart');
            if(ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{ 
                            label: 'Peningkatan Wisatawan', 
                            data: [150, 200, 180, 245, 210, 260], 
                            borderColor: '#2D6A76', 
                            backgroundColor: 'rgba(45, 106, 118, 0.1)',
                            fill: true, 
                            tension: 0.4 
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        });
    </script>
</body>
</html>