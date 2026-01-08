<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Wanderlust</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans text-gray-800">

    <header class="bg-[#2D6A76] text-white p-4 px-10 flex justify-between items-center shadow-md">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.index') }}" class="hover:text-gray-200 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>
        <h2 class="text-xl font-semibold">Pengaturan Profil</h2>
        <div class="flex items-center gap-4">
            <i class="fas fa-user-circle text-2xl"></i>
        </div>
    </header>

    <main class="max-w-4xl mx-auto p-8">
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-xl mb-6 shadow-md flex items-center gap-3">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-[#2D6A76] h-32"></div>
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-8 -mt-16">
                @csrf
                
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <div class="w-full md:w-1/3 flex flex-col items-center">
                        <div class="relative">
                            @if(auth()->user()->foto)
                                <img src="{{ asset('uploads/profile/' . auth()->user()->foto) }}" class="w-40 h-40 rounded-full border-4 border-white shadow-lg object-cover">
                            @else
                                <img src="https://i.pravatar.cc/150?u={{ auth()->user()->id }}" class="w-40 h-40 rounded-full border-4 border-white shadow-lg object-cover">
                            @endif
                            <label for="foto" class="absolute bottom-2 right-2 bg-blue-500 text-white p-2 rounded-full cursor-pointer shadow-md hover:bg-blue-600 transition">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" name="foto" id="foto" class="hidden" accept="image/*">
                        </div>
                        <p class="text-xs text-gray-400 mt-4 text-center">Format: JPG, PNG. Maks 2MB</p>
                    </div>

                    <div class="w-full md:w-2/3 space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#2D6A76] focus:border-transparent outline-none transition">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Email (Hanya Baca)</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-100 bg-gray-50 text-gray-400 cursor-not-allowed outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 uppercase tracking-wider">Bio Singkat</label>
                            <textarea name="bio" rows="4" 
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#2D6A76] focus:border-transparent outline-none transition" 
                                      placeholder="Ceritakan sedikit tentang kamu...">{{ auth()->user()->bio }}</textarea>
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="submit" class="bg-[#2D6A76] text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-[#1e4b54] transition transform hover:-translate-y-1">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                            <button type="reset" class="bg-gray-100 text-gray-600 px-6 py-3 rounded-xl font-bold hover:bg-gray-200 transition">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

</body>
</html>