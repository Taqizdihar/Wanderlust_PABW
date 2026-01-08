<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\Admin\DashboardController; 
use App\Http\Controllers\Admin\TempatWisataController;
use App\Http\Controllers\Admin\VerifikasiDetailController;
use App\Http\Controllers\Ptw\AddPropertyPTWController; //untuk pemilik tempat wisata
use App\Http\Controllers\Ptw\AddTicketPTWController;
use App\Http\Controllers\Ptw\DashboardPTWController;
use App\Http\Controllers\Ptw\EditPropertyPTWController;
use App\Http\Controllers\Ptw\EditTicketPTWController;
use App\Http\Controllers\Ptw\ProfilPTWController;
use App\Http\Controllers\Ptw\PropertyPTWController;
use App\Http\Controllers\Ptw\TicketPTWController;
use App\Http\Controllers\Wisatawan\BookmarkController; //untuk wisatawan
use App\Http\Controllers\Wisatawan\DestinasiController;
use App\Http\Controllers\Wisatawan\editProfilController;
use App\Http\Controllers\Wisatawan\HomeController;
use App\Http\Controllers\Wisatawan\PencarianController;
use App\Http\Controllers\Wisatawan\PenilaianController;
use App\Http\Controllers\Wisatawan\PesanTiketController;
use App\Http\Controllers\Wisatawan\ProfilController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WisataController;

//untuk autentikasi - umum
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/auth', [LoginController::class, 'authenticate'])->name('login.auth');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

//untuk pemilik tempat wisata (PTW) - Taqi
Route::middleware(['auth', 'cekRole:pemilik'])->group(function () {
    Route::get('/dashboard-ptw', [DashboardPTWController::class, 'index'])->name('dashboard.ptw');
    Route::get('/profile-ptw', [ProfilPTWController::class, 'index'])->name('profil.ptw');
    Route::get('/profile-ptw/edit', [ProfilPTWController::class, 'edit'])->name('profil.ptw.edit');
    Route::post('/profile-ptw/update', [ProfilPTWController::class, 'update'])->name('profil.ptw.update');
    Route::get('/properties-ptw', [PropertyPTWController::class, 'index'])->name('properties.ptw');
    Route::delete('/properties-ptw/{id}', [PropertyPTWController::class, 'destroy'])->name('properties.ptw.destroy');
    Route::get('/add-property-ptw', [AddPropertyPTWController::class, 'index'])->name('add.property.ptw');
    Route::post('/add-property-ptw/store', [AddPropertyPTWController::class, 'store'])->name('add.property.store');
    Route::get('/properties-ptw/{id}/edit', [EditPropertyPTWController::class, 'edit'])->name('properties.ptw.edit');
    Route::post('/properties-ptw/{id}/update', [EditPropertyPTWController::class, 'update'])->name('properties.ptw.update');
    Route::get('/properties-ptw/{id}/tickets', [TicketPTWController::class, 'index'])->name('properties.ptw.tickets');
    Route::delete('/tickets-ptw/{id}', [TicketPTWController::class, 'destroy'])->name('tickets.ptw.destroy');
    Route::get('/properties-ptw/{id}/tickets/create', [AddTicketPTWController::class, 'create'])->name('tickets.ptw.create');
    Route::post('/properties-ptw/{id}/tickets/store', [AddTicketPTWController::class, 'store'])->name('tickets.ptw.store');
    Route::get('/tickets-ptw/{id}/edit', [EditTicketPTWController::class, 'edit'])->name('tickets.ptw.edit');
    Route::post('/tickets-ptw/{id}/update', [EditTicketPTWController::class, 'update'])->name('tickets.ptw.update');
});


// ROUTE PUBLIK (TIDAK MEMERLUKAN LOGIN / GUEST ACCESS)
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/homeWisatawan', function () {
    return redirect('/home');
});
Route::get('/pencarian', [PencarianController::class, 'index'])->name('pencarian');
Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi.index'); 
Route::middleware(['auth:wisatawan'])->group(function () {
    
    // Aksi Bookmark (dari AJAX/Fetch)
    Route::post('/bookmark/toggle/{idTempat}', [BookmarkController::class, 'toggle'])->name('bookmark.toggle'); 

    // Aksi Penilaian (POST untuk menyimpan ulasan dan rating)
    Route::post('/penilaian/store', [PenilaianController::class, 'store'])->name('penilaian.store'); 
    
    // Pesan Tiket
    Route::get('/pesan-tiket/{idPaket}', [PesanTiketController::class, 'showForm'])->name('pesan.tiket.form'); 
    Route::post('/pesan-tiket/store', [PesanTiketController::class, 'store'])->name('pesan.tiket.store'); 

    Route::get('/riwayat-transaksi', [\App\Http\Controllers\PesanTiketController::class, 'riwayat'])->name('transaksi.riwayat');

    // Halaman Profil 
    Route::get('/editProfil', [editProfilController::class,'index'])->name('editProfil');
    Route::get('/profil', [\App\Http\Controllers\ProfilController::class, 'showProfile'])->name('profil');
    Route::get('/edit-profil', [\App\Http\Controllers\editProfilController::class, 'show'])->name('edit-profil');
    Route::post('/update-profil', [\App\Http\Controllers\editProfilController::class, 'update'])->name('update.profil');

    // Route untuk Halaman Favorit/Bookmark (Perlu dibuat)
    Route::get('/favorit', [BookmarkController::class, 'index'])->name('bookmark.index');
    
    // Route untuk Halaman Penilaian (Perlu dibuat)
    Route::get('/daftar-penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');

});

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/admin/toggle/{id}', [AdminController::class, 'toggleStatus'])->name('admin.toggle');
Route::post('/admin/delete/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
Route::get('/admin/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/admin/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/admin/wisata', [WisataController::class, 'index'])->name('wisata.index');
Route::get('/admin/wisata/review/{id}', [WisataController::class, 'review'])->name('wisata.review');
Route::post('/admin/wisata/approve/{id}', [WisataController::class, 'approve'])->name('wisata.approve');
Route::get('/admin/wisata', [WisataController::class, 'index'])->name('wisata.index');
Route::delete('/admin/wisata/delete/{id}', [WisataController::class, 'destroy'])->name('wisata.delete');
Route::get('/admin/wisata/review/{id}', [WisataController::class, 'review'])->name('wisata.review');
Route::post('/admin/wisata/approve/{id}', [WisataController::class, 'approve'])->name('wisata.approve');
Route::post('/admin/wisata/revisi/{id}', [WisataController::class, 'revisi'])->name('wisata.revisi');
Route::delete('/admin/wisata/delete/{id}', [WisataController::class, 'destroy'])->name('wisata.delete');
Route::get('/admin/wisata/tambah', [WisataController::class, 'create'])->name('wisata.create');
Route::post('/admin/wisata/simpan', [WisataController::class, 'store'])->name('wisata.store');
Route::get('/admin/users/create', function() {
 return view('admin', ['page' => 'tambah_user', 'users' => \App\Models\User::all()]);
})->name('admin.user.create');
Route::post('/admin/users/store', [AdminController::class, 'storeUser'])->name('admin.user.store');
