<nav class="sidebar">
    <div class="logo-section">
        <img src="{{ asset('images/Logos/Wanderlust Logo Circle.png') }}" alt="Logo" class="logo-img">
        <div class="brand-text">
            <h2>Wanderlust</h2>
            <p>WANDERINGS FOR WONDERS</p>
        </div>
    </div>

    <div class="menu-label">Menu</div>

    <ul class="nav-links">
        <li>
            <a href="{{ route('dashboard.ptw') }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('profil.ptw') }}" class="{{ request()->routeIs('profil.ptw') ? 'active' : '' }}"> <i class="fas fa-user"></i> Profile Page
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-dollar-sign"></i> Revenue
            </a>
        </li>
        <li>
            <a href="{{ route('properties.ptw') }}">
                <i class="fas fa-map-marker-alt"></i> Properties
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-ticket-alt"></i> Tickets
            </a>
        </li>
        <li>
            <a href="#">
                <i class="fas fa-question-circle"></i> Help Centre
            </a>
        </li>
    </ul>

    <form action="{{ route('logout') }}" method="POST" id="logout-form">
        @csrf
        <button type="submit" class="logout-btn" onclick="return confirm('Are you sure you want to log out?');">
            <i class="fas fa-sign-out-alt"></i> Log Out
        </button>
    </form>
</nav>