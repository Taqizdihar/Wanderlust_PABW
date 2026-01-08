<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Wanderlust</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
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
        @if(Auth::check())
            <a href="{{ route('profil') }}" class="user-icon"><i class="fas fa-user"></i></a>
        @else
            <a href="{{ route('login') }}" class="btn-login">Login</a>
        @endif
    </div>
</header>

<div class="container">
    <h2 class="section-title">Destinasi Populer</h2>
    <div class="destinations-grid">
        @foreach($populer as $item)
        <div class="card">
            <div class="image-container">
                {{-- Memanggil asset langsung dari path yang sudah kita buat di Controller --}}
                <img src="{{ asset($item->foto) }}" alt="{{ $item->nama }}" onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';">
                
                @if(Auth::check())
                    <button class="bookmark-btn {{ $item->is_bookmarked ? 'active' : '' }}" data-id="{{ $item->id_tempat }}">
                        <i class="fa-{{ $item->is_bookmarked ? 'solid' : 'regular' }} fa-bookmark"></i>
                    </button>
                @endif
            </div>
            <div class="card-content">
                <div class="card-header">
                    <h3>{{ $item->nama }}</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <span>{{ $item->rating }}</span>
                    </div>
                </div>
                <p class="location"><i class="fas fa-map-marker-alt"></i> {{ $item->lokasi }}</p>
                <div class="card-footer">
                    <div class="price-container">
                        <span class="price-value">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ url('/detail/'.$item->id_tempat) }}" class="btn-detail-link">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

    <h2 class="section-title" style="margin-top: 40px;">Rekomendasi Destinasi</h2>
    <div class="destinations-grid">
        @foreach($rekomendasi as $item)
        <div class="card">
            <div class="image-container">
                <img src="{{ asset($item->foto) }}" alt="{{ $item->nama }}" onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';">
            </div>
            <div class="card-content">
                <div class="card-header">
                    <h3>{{ $item->nama }}</h3>
                    <div class="rating">
                        <i class="fas fa-star"></i>
                        <span>{{ $item->rating }}</span>
                    </div>
                </div>
                <p class="location"><i class="fas fa-map-marker-alt"></i> {{ $item->lokasi }}</p>
                <div class="card-footer">
                    <div class="price-container">
                        <span class="price-value">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ url('/detail/'.$item->id_tempat) }}" class="btn-detail-link">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
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
                <a href="{{ route('profil') }}">Profil</a>
                <a href="#">Agenda</a>
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