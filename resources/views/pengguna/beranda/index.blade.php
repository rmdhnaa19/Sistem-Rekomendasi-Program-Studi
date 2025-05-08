@extends('layouts.navbar')
@section('content')
    <!-- Konten utama -->
    <section class="hero pt-5 pb-5" >
        <div class="container">
            <div class="row align-items-center gy-5">
                <!-- Teks -->
                <div class="col-md-6">
                    <h1 class="fw-bold fs-3 mb-3">
                        {{ $profile->judul ?? 'Selamat Datang!' }}
                    </h1>
                    <p class="fs-6 mb-4 text-secondary">
                        {{ $profile->deskripsi ?? 'Temukan informasi lengkap seputar pendaftaran mahasiswa baru di Poliwangi.' }}
                    </p>
                    <a href="{{ route('pengguna.konsultasi.index') }}" class="btn btn-warning btn-lg fw-bold style="background-color: #FDA702;" >
                        Cek sekarang! 🔍
                    </a>
                </div>

                <!-- Video -->
                <div class="col-md-6 text-center">
                    @php
                        $youtubeUrl = $profile->youtube_link ?? 'https://youtu.be/gRHBOxMDKa0?si=2HzfHMfWOMOawjB3';
                        $embedUrl = str_replace(['youtu.be/', 'watch?v='], ['www.youtube.com/embed/', 'embed/'], $youtubeUrl);
                    @endphp
                    <div class="ratio ratio-16x9" style="border-radius: 10px; overflow: hidden;">
                        <iframe 
                            src="{{ $embedUrl }}"
                            title="YouTube video player"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
