<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - {{ $user->nama ?? 'Pengguna' }}</title>
    
    <link rel="stylesheet" href="{{ asset('css/profil.css') }}"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<header class="main-header">
    <div class="logo-container">
        <img src="{{ asset('/images/Logos/Wanderlust Logo Circle.png') }}" alt="Logo" class="logo">
        <div class="logo-text">
            <span class="title">Wanderlust</span>
            <span class="subtitle">WANDERINGS FOR WONDERS</span> 
        </div>
    </div>

    <form action="{{ route('pencarian') }}" method="GET" class="search-bar">
        <input type="text" name="kataKunci" placeholder="Cari destinasi wisata..." required>
        <button type="submit" class="search-button">
            <i class="search-icon fas fa-search"></i>
        </button>
    </form>

    <div class="nav-links">
        <a href="{{ Auth::check() ? route('transaksi.riwayat') : route('login') }}">Pesan Tiket</a>
        <a href="{{ Auth::check() ? route('penilaian.index') : route('login') }}">Penilaian</a>
        <a href="{{ Auth::check() ? route('bookmark.index') : route('login') }}">Favorit</a>

<a href="{{ Auth::check() ? route('profil') : route('login') }}">
    <div class="profile-icon">
        @if(Auth::check() && Auth::user()->foto_profil)
            <img src="{{ asset('storage/images/profiles/' . Auth::user()->foto_profil) }}" alt="Foto Profil">
        @else
            <i class="fas fa-user"></i>
        @endif
    </div>
</a>

    </div>
</header>

<div class="profile-form">
    <div class="sidebar">
        <img src="{{ asset('storage/images/profiles/' . ($user->foto_profil ?? 'default.png')) }}" alt="Foto Profil" class="profile-pic">
        
        <a href="{{ route('edit-profil') }}" class="edit-btn">Edit Profil</a>
        
        <ul class="menu-options">
            <li><a href="{{ route('home') }}">🏠 Beranda</a></li>
            <li><a href="{{ route('profil') }}" class="active-option">👤 Profil</a></li>
            <li><a href="{{ route('bookmark.index') }}">⭐ Favorit</a></li>
            <li><a href="#">💰 Pembayaran</a></li>
            <li><a href="{{ route('logout') }}">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="profile-card">
        <h2>{{ $user->nama ?? 'Nama Pengguna' }}</h2>

        @if (session('success'))
            <div class="alert success-alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="form-grid">
            
            <div class="form-group">
                <label>Email</label>
                <span>{{ $user->email ?? '-' }}</span>
            </div>

            <div class="form-group"> 
                <label>No Telepon</label>
                <span>{{ $wisatawan->no_telepon ?? '-' }}</span>
            </div>

            <div class="form-group">
                <label>Tanggal Lahir</label>
                <span>{{ $wisatawan->tanggal_lahir ? \Carbon\Carbon::parse($wisatawan->tanggal_lahir)->format('F d, Y') : '-' }}</span>
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <span>{{ ($wisatawan->jenis_kelamin ?? '') == 'L' ? 'Laki-laki' : ( ($wisatawan->jenis_kelamin ?? '') == 'P' ? 'Perempuan' : '-') }}</span>
            </div>
            
            <div class="form-group">
                <label>Usia</label>
                <span>{{ floor(floatval($usia)) }} Tahun</span> 
            </div>

            <div class="form-group">
                <label>Status Akun</label>
                <span>{{ $wisatawan->status_akun ?? 'Aktif' }}</span>
            </div>

            <div class="form-group">
                <label>Kota Asal</label>
                <span>{{ $wisatawan->kota_asal ?? '-' }}</span>
            </div>

            <div class="form-group">
                <label>Preferensi Wisata</label>
                <span>{{ $wisatawan->preferensi_wisata ?? '-' }}</span>
            </div>
            
            <div class="form-group full-width-grid">
                <label>Alamat</label>
                <span>{{ $wisatawan->alamat ?? '-' }}</span>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('home') }}" class="btn cancel-btn">Kembali</a> 
        </div>
    </div>
</div>

<footer class="footer">
    <div class="footer-top">
        <div class="footer-left">
            <div class="logo-text footer-logo">
                <img src="{{ asset('/images/Logos/Wanderlust Logo Circle.png') }}" alt="Logo" class="logo-img">
                <span class="title">Wanderlust</span>
            </div>
        </div>

        <div class="footer-links-container">
            <div class="footer-column">
                <a href="#">Tentang Kami</a>
                <a href="#">Kontak Kami</a>
                <a href="#">FAQs</a>
            </div>

            <div class="footer-column">
                <a href="#">Komunitas</a>
                <a href="#">Tips & Trick</a>
                <a href="#">Promo</a>
            </div>

            <div class="footer-column">
                <a href="{{ route('profil') }}">Profil</a> <a href="#">Agenda</a>
                <a href="{{ route('home') }}">Home</a>
            </div>
        </div>
    </div>
    
    <div class="footer-center">
        Copyright © 2025 Wanderlust. All rights reserved
    </div>
</footer>
</body>
</html>