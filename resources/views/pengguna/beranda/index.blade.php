@extends('layouts.navbar')

@section('content')
    <!-- Konten utama -->
        <section class="hero" style="margin-top: 70px;">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="fw-bold">
                            {{ $profile->judul ?? 'Selamat Datang!' }}
                        </h1>
                        <p class="lead">
                            {{ $profile->deskripsi ?? 'Temukan informasi lengkap seputar pendaftaran mahasiswa baru di Poliwangi.' }}
                        </p>
                        <a href="{{ route('pengguna.konsultasi.index') }}" class="btn btn-warning btn-lg fw-bold">
                            Cek sekarang! 🔍
                        </a>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="embed-responsive embed-responsive-16by9">
                            @php
                            $youtubeUrl = $profile->youtube_link ?? 'https://youtu.be/gRHBOxMDKa0?si=2HzfHMfWOMOawjB3';
                            $embedUrl = str_replace(['youtu.be/', 'watch?v='], ['www.youtube.com/embed/', 'embed/'], $youtubeUrl);
                            @endphp
                            <iframe class="embed-responsive-item" width="100%" height="350"
                                src="{{ $embedUrl }}"
                                title="YouTube video player" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                style="border-radius: 10px; overflow: hidden;">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
