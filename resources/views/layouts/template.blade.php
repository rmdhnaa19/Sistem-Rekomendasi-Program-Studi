<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PRISM | @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />
    <link rel="stylesheet"
        href="{{ asset('voler-master/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('storage/asset_web/Logo Fluks Baru BG wth.png') }}" type="image/x-icon">
    
    <!-- Load DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Include Choices CSS -->
    <link rel="stylesheet" href="{{ asset('voler-master/dist/assets/vendors/choices.js/choices.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/template.css') }}">

    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jurusan.css') }}">     
    <link rel="stylesheet" href="{{ asset('css/prodi.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/kecerdasan_majemuk.css') }}"> 
    <link rel="stylesheet" href="{{ asset('css/pertanyaan_kecerdasan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kriteria.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kasus_lama.css') }}"> 

    {{-- <link rel="stylesheet" href="{{ asset('css/kelolaGudang.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelolaPJGudang.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelolaPakan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelolaPakanGudang.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelolaTransaksiPakan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/transaksiPakan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelolaAlat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelolaAlatGudang.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelolaTransaksiAlat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/transaksiAlat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelolaObat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelolaObatGudang.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kelolaTransaksiObat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/transaksiObat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manajemenKolam.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manajemenTambak.css') }}">
    <link rel="stylesheet" href="{{ asset('css/faseKolam.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pjTambak.css') }}">
    <link rel="stylesheet" href="{{ asset('css/anco.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kualitasAir.css') }}">
    <link rel="stylesheet" href="{{ asset('css/penanganan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sampling.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pakanHarian.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kematianUdang.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fasekolamuser.css') }}"> --}}
    @stack('css')
</head>

<body>
    @include('sweetalert::alert')
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                @include('layouts.sidebar')
            </div>
        </div>
        <div id="main">
            @include('layouts.header')
            <div class="main-content container-fluid">
                <div class="page-title">
                    @include('layouts.breadcrumb')
                </div>
                <section class="section">
                    @yield('content')
                </section>
            </div>
            {{-- <nav>
                <ul>
                    @foreach (\App\Models\PagesModel::all() as $page)
                        <li><a href="{{ route('page.show', $page->slug) }}">{{ $page->title }}</a></li>
                    @endforeach
                </ul>
            </nav> --}}
            
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    @include('layouts.footer')
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('voler-master/dist/assets/js/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('voler-master/src/assets/js/app.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script src="{{ asset('voler-master/dist/assets/js/vendors.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/js/main.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('voler-master/dist/assets/bootstrap-4.0.0-dist/js/bootstrap.min.js') }}"></script>
    <!-- Load jQuery (versi yang Anda gunakan) -->
    <script src="{{ asset('javascript/jquery-3.7.1.min.js') }}"></script>
    <!-- Load DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://kit.fontawesome.com/75f7078132.js" crossorigin="anonymous"></script>
    <script src="{{ asset('voler-master/dist/assets/vendors/choices.js/choices.min.js') }}"></script>
    <!-- Bootstrap JS (versi yang sesuai) -->
    <script src="{{ asset('javascript/bootstrap.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('javascript/sweetalert2@11.js') }}"></script>


    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.has-sub > a').on('click', function(e) {
                e.preventDefault();
                $(this).parent().toggleClass('active');
            });
        });
    </script>
    <script>
        // Ambil elemen toggle dan menu
        const dropdownToggle = document.getElementById('dropdownToggle');
        const dropdownMenu = document.getElementById('dropdownMenu');

        // Tambahkan event listener ke elemen toggle
        dropdownToggle.addEventListener('click', function(event) {
            // Mencegah tindakan default link
            event.preventDefault();

            // Toggle kelas 'show' pada dropdown menu
            dropdownMenu.classList.toggle('show');
        });

        // Menutup dropdown jika klik di luar
        document.addEventListener('click', function(event) {
            // Periksa apakah klik terjadi di luar toggle atau menu
            if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    </script>
    @stack('js')
</body>

</html>
