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
        
        <a href="{{ Auth::check() ? route('profil') : route('login') }}">
            <div class="profile-icon">
                @if(Auth::check() && Auth::user()->foto_profil)
                    <img src="{{ asset('images/profiles/' . Auth::user()->foto_profil) }}" alt="Foto Profil">
                @else
                    <i class="fas fa-user"></i>
                @endif
            </div>
        </a>
    </div>
</header>

<h2 class="section-title">Destinasi Populer</h2>
<div class="card-gallery">
    @foreach ($populer as $item)
    <div class="cards-destination">
        <div class="card-images" style="{{ 'background-image: url(\'' . asset('images/Images') . '/' . $item['foto'] . '\')' }}">
            
            <a href="{{ Auth::check() ? '#' : route('login') }}" 
               class="bookmark-icon bookmark-toggle" 
               data-id-tempat="{{ $item['id_tempat'] ?? '0' }}">
                <i class="fas fa-bookmark {{ $item['is_bookmarked'] ?? false ? 'active' : '' }}"></i>
            </a>
            
        </div>
        
        <div class="card-info-box">
            <h4 class="destination-name">{{ $item['nama'] }}</h4>
            
            <div class="rating-box">
                <span class="stars">
                    @php
                        $rating = $item['rating'] ?? 0;
                        $fullStars = floor($rating);
                        $hasHalf = ($rating - $fullStars) >= 0.5;
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $fullStars)
                            <i class="fas fa-star"></i>
                        @elseif ($hasHalf && $i == $fullStars + 1)
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </span>
                <span class="rating-text">{{ $item['rating'] ?? 'N/A' }} ({{ $item['reviews'] ?? 0 }} reviews)</span>
            </div>
        </div>
        <div class="card-detail-body">
            <p class="location-text-white-small">{{ $item['lokasi'] ?? 'Lokasi Tidak Tersedia' }}</p>

            <p class="card-description-text">
                {{ substr($item['deskripsi'] ?? 'Jelajahi keindahan destinasi wisata ini dengan paket spesial kami.', 0, 70) }}...
            </p>
            
            <div class="card-price-action-wrapper">
                <div class="price-text-container">
                    <div class="price-block">
                        <span class="price-start">Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
                <a href="/detail/{{ $item['id_tempat'] }}" class="btn-detail-link">Lihat Detail</a>
            </div>
        </div>
    </div> 
    @endforeach
</div>

<h2 class="section-title">Rekomendasi Destinasi</h2>
<div class="card-gallery">
    @foreach ($rekomendasi as $item)
    <div class="cards-destination">
        <div class="card-images" style="{{ 'background-image: url(\'' . asset('images/Images') . '/' . $item['foto'] . '\')' }}">
            
            <a href="{{ Auth::check() ? '#' : route('login') }}" 
               class="bookmark-icon bookmark-toggle" 
               data-id-tempat="{{ $item['id_tempat'] ?? '0' }}">
                <i class="fas fa-bookmark {{ $item['is_bookmarked'] ?? false ? 'active' : '' }}"></i>
            </a>

        </div>
        
        <div class="card-info-box">
            <h4 class="destination-name">{{ $item['nama'] }}</h4>
            
            <div class="rating-box">
                <span class="stars">
                    @php
                        $rating = $item['rating'] ?? 0;
                        $fullStars = floor($rating);
                        $hasHalf = ($rating - $fullStars) >= 0.5;
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $fullStars)
                            <i class="fas fa-star"></i>
                        @elseif ($hasHalf && $i == $fullStars + 1)
                            <i class="fas fa-star-half-alt"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </span>
                <span class="rating-text">{{ $item['rating'] ?? 'N/A' }} ({{ $item['reviews'] ?? 0 }} reviews)</span>
            </div>
        </div>
        <div class="card-detail-body">
            <p class="location-text-white-small">{{ $item['lokasi'] ?? 'Lokasi Tidak Tersedia' }}</p>

            <p class="card-description-text">
                {{ substr($item['deskripsi'] ?? 'Jelajahi keindahan destinasi wisata ini dengan paket spesial kami.', 0, 70) }}...
            </p>
            
            <div class="card-price-action-wrapper">
                <div class="price-text-container">
                    <div class="price-block">
                        <span class="price-start">Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
                <a href="/detail/{{ $item['id_tempat'] }}" class="btn-detail-link">Lihat Detail</a>
            </div>
        </div>
    </div>
    @endforeach
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

@if(Auth::check())
<script>
    document.querySelectorAll('.bookmark-toggle').forEach(button => {
    });
</script>
@endif

</body>
</html>