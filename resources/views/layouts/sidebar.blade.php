{{-- Load Sidebar CSS --}}
{{-- <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}"> --}}

{{-- Sidebar Menu --}}
<div class="sidebar-menu">
    <ul class="menu">

{{-- Sidebar Header --}}
<div class="sidebar-header">
    <img src="{{ asset('images/pmb-poliwangi.png') }}" alt="Logo" class="sidebar-logo" style="margin-bottom: 3px" />
</div>

        {{-- Menu Dashboard --}}
        <li class="sidebar-item {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
            <a href="{{ url('/dashboard') }}" class='sidebar-link'>
                <x-svg-icon icon="dashboard" />
                <span>Dashboard</span>
            </a>
        </li>

        <li class='sidebar-title'>MANAJEMEN USER</li>
        <li class="sidebar-item {{ $activeMenu == 'kelolaUser' ? 'active' : '' }}">
            <a href="{{ url('/user') }}" class='sidebar-link'>
                <x-svg-icon icon="user" />
                <span>Kelola User</span>
            </a>
        </li>

        {{-- Kelola Data --}}
        <li class='sidebar-title'>MANAJEMEN DATA</li>

        {{-- <li class="sidebar-item {{ $activeMenu == 'kelolaMenu' ? 'active' : '' }}">
            <a href="{{ url('/pages') }}" class='sidebar-link'>
                <x-svg-icon icon="user" />
                <span>Kelola Menu</span>
            </a>
        </li> --}}

        <li class="sidebar-item {{ $activeMenu == 'kelolaProfileKampus' ? 'active' : '' }}">
            <a href="{{ route('profile_kampus.edit', ['id' => $hero->id ?? 1]) }}" class='sidebar-link'>
                <x-svg-icon icon="profile_kampus" />
                <span>Kelola Profile Kampus</span>
            </a>
        </li>
        
        <li class="sidebar-item {{ $activeMenu == 'jurusan' ? 'active' : '' }}">
            <a href="{{ url('/jurusan') }}" class='sidebar-link'>
                <x-svg-icon icon="jurusan" />
                <span>Kelola Jurusan</span>
            </a>
        </li>
        
        <li class="sidebar-item {{ $activeMenu == 'prodi' ? 'active' : '' }}">
            <a href="{{ url('/prodi') }}" class='sidebar-link'>
                <x-svg-icon icon="program_studi" />
                <span>Kelola Program Studi</span>
            </a>
        </li>

        <li class="sidebar-item {{ $activeMenu == 'kriteria' ? 'active' : '' }}">
            <a href="{{ url('/kriteria') }}" class='sidebar-link'>
                <x-svg-icon icon="kriteria" />
                <span>Kelola Kriteria</span>
            </a>
        </li>

        <li class="sidebar-item {{ $activeMenu == 'kecerdasan_majemuk' ? 'active' : '' }}">
            <a href="{{ url('/kecerdasan_majemuk') }}" class='sidebar-link'>
                <x-svg-icon icon="kecerdasan_majemuk" />
                <span>Kelola Kecerdasan Majemuk</span>
            </a>
        </li>
        <li class="sidebar-item {{ $activeMenu == 'pertanyaan_kecerdasan' ? 'active' : '' }}">
            <a href="{{ url('/pertanyaan_kecerdasan') }}" class='sidebar-link'>
                <x-svg-icon icon="pertanyaan_kecerdasan" />
                <span>Kelola Pertanyaan Kecerdasan</span>
            </a>
        </li>
        
        <li class="sidebar-item {{ $activeMenu == 'jurusan_asal' ? 'active' : '' }}">
            <a href="{{ url('/jurusan_asal') }}" class='sidebar-link'>
                <x-svg-icon icon="jurusan_asal" />
                <span>Kelola Jurusan Asal</span>
            </a>
        </li>

        <li class="sidebar-item {{ $activeMenu == 'prestasi' ? 'active' : '' }}">
            <a href="{{ url('/prestasi') }}" class='sidebar-link'>
                <x-svg-icon icon="prestasi" />
                <span>Kelola Prestasi</span>
            </a>
        </li>

        <li class="sidebar-item {{ $activeMenu == 'organisasi' ? 'active' : '' }}">
            <a href="{{ url('/organisasi') }}" class='sidebar-link'>
                <x-svg-icon icon="organisasi" />
                <span>Kelola Organisasi</span>
            </a>
        </li>

        <li class="sidebar-item {{ $activeMenu == 'batas_threshold' ? 'active' : '' }}">
            <a href="{{ route('batas_threshold.edit') }}" class="sidebar-link">
                <x-svg-icon icon="batas_threshold" />
                <span>Kelola Batas Threshold</span>
            </a>
        </li>

        <li class="sidebar-item {{ $activeMenu == 'kasus_lama' ? 'active' : '' }}">
            <a href="{{ url('/kasus_lama') }}" class='sidebar-link'>
                <x-svg-icon icon="kasus_lama" />
                <span>Kelola Kasus Lama</span>
            </a>
        </li>

        <li class="sidebar-item {{ $activeMenu == 'normalisasi' ? 'active' : '' }}">
            <a href="{{ url('/normalisasi') }}" class='sidebar-link'>
                <x-svg-icon icon="normalisasi" />
                <span>Hasil Normalisasi</span>
            </a>
        </li>

        <li class="sidebar-item {{ $activeMenu == 'revise' ? 'active' : '' }}">
            <a href="{{ url('/revise') }}" class='sidebar-link'>
                <x-svg-icon icon="revise" />
                <span>Kelola Revise</span>
            </a>
        </li>

        <li class="sidebar-item {{ $activeMenu == 'riwayat-konsultasi' ? 'active' : '' }}">
            <a href="{{ url('/riwayat-konsultasi') }}" class='sidebar-link'>
                <x-svg-icon icon="riwayat" />
                <span>Riwayat Konsultasi</span>
            </a>
        </li>

        
        {{-- <li class="sidebar-item {{ $activeMenu == 'sub_kriteria' ? 'active' : '' }}">
            <a href="{{ url('/sub_kriteria') }}" class='sidebar-link'>
                <x-svg-icon icon="user" />
                <span>Kelola Sub Kriteria</span>
            </a>
        </li> --}}

        {{-- <li class="sidebar-item {{ $activeMenu == 'kelolaIndexing' ? 'active' : '' }}">
            <a href="{{ url('/kelolaIndexing') }}" class='sidebar-link'>
                <x-svg-icon icon="user" />
                <span>Kelola Indexing</span>
            </a>
        </li> --}}

        {{-- <li class="sidebar-item {{ $activeMenu == 'kelolaHasilRekomendasi' ? 'active' : '' }}">
            <a href="{{ url('/kelolaHasilRekomendasi') }}" class='sidebar-link'>
                <x-svg-icon icon="user" />
                <span>Kelola Hasil Rekomendasi</span>
            </a>
        </li> --}}
    </ul>
</div>

{{-- Sidebar Toggler --}}
<button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
