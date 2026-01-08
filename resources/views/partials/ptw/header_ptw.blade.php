<header class="top-header">
    <div class="header-left">
        <h3>Dashboard of {{ $ptw->nama_organisasi ?? 'ORGANISASI BELUM DISET' }}</h3>
        <p>organized by {{ $user->nama }}</p>
    </div>

    <div class="header-right">
        <div class="icon-btn"><i class="fas fa-paper-plane"></i></div>
        <div class="icon-btn"><i class="fas fa-envelope"></i></div>

        <a href="{{ route('profil.ptw') }}" title="Ke Halaman Profil"> 
            @if($ptw->foto_organisasi)
                <img src="{{ asset($ptw->foto_organisasi) }}" alt="Org Logo" class="kemen-logo">
            @else
                <img src="{{ asset('images/logos/default_logo.png') }}" alt="Default" class="kemen-logo">
            @endif
        </a>

    </div>
</header>