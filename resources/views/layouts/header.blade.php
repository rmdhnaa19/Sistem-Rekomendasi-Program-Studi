<nav class="navbar navbar-header navbar-expand navbar-light">
    <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
    <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
            <li class="dropdown">
                <a href="#" id="dropdownToggle" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    {{-- <div class="avatar mr-1">
                        @if (auth()->user() && auth()->user()->foto != '')
                            <img src="{{ Storage::url(auth()->user()->foto) }}" alt="foto">
                        @else
                            <img src="{{ asset('storage/asset_web/blank.png') }}" alt="foto">
                        @endif
                    </div> --}}
                    <div class="avatar mr-1">
                        @if (auth()->user()->foto != '')
                            <img src="{{ Storage::url(auth()->user()->foto) }}" alt="foto">
                        @else
                            <img src="{{ asset('storage/asset_web/blank.png') }}" alt="foto">
                        @endif
                    </div>
                    <div class="d-none d-md-block d-lg-inline-block">Selamat Datang, {{ auth()->user() ? auth()->user()->nama : 'Guest' }}</div>
                </a>
                <div id="dropdownMenu" class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('profile.edit', ['id' => Auth::id()]) }}">
                        <i data-feather="user"></i>
                        Edit Profil
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('login.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item"><i data-feather="log-out"></i> Logout</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
