@extends('layouts.navbar')
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Rekomendasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
        }

        /* Jika kamu ingin ukuran heading lebih rapi */
        h2, h4 {
            font-weight: 600;
        }

        table th, table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="container py-2">
        <h2 class="text-center fw-bold">HASIL KONSULTASI</h2>
        <!-- Informasi Pengguna -->
        <div class="p-4 mb-4 rounded shadow-sm" style="background-color: #d0dbf0;">
            <h4 class="fw-bold">Informasi Pengguna</h4>
            <p><strong>Nama:</strong> {{ session('konsultasi.nama', 'Tidak tersedia') }}</p>
            <p><strong>Nilai Rata-rata Rapor:</strong> {{ session('konsultasi.nilai_rata_rata_rapor', '-') }}</p>
            <p><strong>Asal Jurusan:</strong> {{ session('konsultasi.jurusan_asal', '-') }}</p>
            <p><strong>Prestasi:</strong> {{ session('konsultasi.prestasi', '-') }}</p>
            <p><strong>Keaktifan Organisasi:</strong> {{ session('konsultasi.organisasi', '-') }}</p>
        </div>

        {{-- <ul>
            @foreach(session('poin_kecerdasan', []) as $key => $poin)
                <li>Kecerdasan {{ str_replace('_', ' ', str_replace('kec_', '', $key)) }} : {{ $poin }}</li>
            @endforeach
        </ul>              --}}

        <div class="p-4 my-4 rounded shadow-sm" style="background-color: #e4effa;">
    <h4 class="fw-bold mb-3">Hasil Tes Kecerdasan Majemuk</h4>

    @foreach(session('jawaban_kecerdasan', []) as $jenis => $daftarJawaban)
        @php
            $jumlahPoin = count($daftarJawaban);
        @endphp

        <p class="fw-bold mt-3">{{ $jenis }} ({{ $jumlahPoin }} poin)</p>
        <ul>
            @foreach($daftarJawaban as $jawaban)
                <li>{{ $jawaban }}</li>
            @endforeach
        </ul>
    @endforeach
</div>
        <!-- Tabel Hasil Rekomendasi -->
        <h4 class="fw-bold text-center mt-4">Rekomendasi Program Studi</h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Kode Kasus</th>
                        <th>Program Studi</th>
                        <th>Nilai Kemiripan</th>
                        <th>Peringkat</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasilRekomendasi = session('hasil_rekomendasi', []);
                        usort($hasilRekomendasi, fn($a, $b) => $b['nilai_kemiripan'] <=> $a['nilai_kemiripan']);
                        $topRekomendasi = array_slice($hasilRekomendasi, 0, 3);
                        $nilaiTertinggi = count($hasilRekomendasi) > 0 ? max(array_column($hasilRekomendasi, 'nilai_kemiripan')) : 0;
                    @endphp

                    @forelse($topRekomendasi as $index => $hasil)
                        <tr>
                            <td class="fw-bold">{{ $index + 1 }}</td>
                            <td class="fw-bold text-primary">{{ $hasil['kd_kasus_lama'] ?? 'Tidak ada' }}</td>
                            <td>{{ $hasil['nama_prodi'] ?? 'Tidak tersedia' }}</td>
                            <td>{{ $hasil['nilai_kemiripan'] }}</td>
                            <td class="fw-bold">{{ $index + 1 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger fw-bold">Tidak ada rekomendasi ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Peringatan jika similarity rendah -->
        @if($nilaiTertinggi < 0.90)
            <div class="alert alert-warning mt-3">
                <p><strong>Mohon maaf</strong>, program studi yang direkomendasikan memiliki kesamaan yang rendah.</p>
                <p>Kasus Anda akan disimpan sebagai <strong>kasus baru</strong> dalam sistem untuk membantu rekomendasi selanjutnya.</p>
            </div>
        @endif

        {{-- <div class="text-center mt-4 mb-5">
            <a href="{{ route('pengguna.beranda') }}" class="btn btn-primary">Kembali ke Beranda</a>
        </div> --}}
    </div>
</body>
</html>


{{-- responsif --}}

{{-- @extends('layouts.navbar')
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Rekomendasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @media (max-width: 576px) {
            .container {
                padding: 10px !important;
            }
            .table th, .table td {
                font-size: 14px;
                word-break: break-word;
            }
            .p-4 {
                padding: 1rem !important;
            }
            h2, h4 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5" style="margin-top: 80px;">
        <h2 class="text-center fw-bold">HASIL KONSULTASI</h2>

        <!-- Informasi Pengguna -->
        <div class="p-4 mb-4 rounded shadow-sm" style="background-color: #d0dbf0;">
            <h4 class="fw-bold">Informasi Pengguna</h4>
            <p><strong>Nama:</strong> {{ session('konsultasi.nama', 'Tidak tersedia') }}</p>
            <p><strong>Nilai Rata-rata Rapor:</strong> {{ session('konsultasi.nilai_rata_rata_rapor', '-') }}</p>
            <p><strong>Asal Jurusan:</strong> {{ session('konsultasi.jurusan_asal', '-') }}</p>
            <p><strong>Prestasi:</strong> {{ session('konsultasi.prestasi', '-') }}</p>
            <p><strong>Keaktifan Organisasi:</strong> {{ session('konsultasi.organisasi', '-') }}</p>
        </div>

        <!-- Hasil Tes Kecerdasan Majemuk -->
        <div class="p-4 my-4 rounded shadow-sm" style="background-color: #e4effa;">
            <h4 class="fw-bold mb-3">Hasil Tes Kecerdasan Majemuk</h4>

            @foreach(session('jawaban_kecerdasan', []) as $jenis => $daftarJawaban)
                @php
                    $jumlahPoin = count($daftarJawaban);
                @endphp

                <p class="fw-bold mt-3">{{ $jenis }} ({{ $jumlahPoin }} poin)</p>
                <ul>
                    @foreach($daftarJawaban as $jawaban)
                        <li>{{ $jawaban }}</li>
                    @endforeach
                </ul>
            @endforeach
        </div>

        <!-- Tabel Hasil Rekomendasi -->
        <h4 class="fw-bold text-center mt-4">Rekomendasi Program Studi</h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>Kode Kasus</th>
                        <th>Program Studi</th>
                        <th>Nilai Kemiripan</th>
                        <th>Peringkat</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Mengambil data hasil rekomendasi dari session
                        $hasilRekomendasi = session('hasil_rekomendasi', []);

                        // Sortir data berdasarkan nilai kemiripan dari yang tertinggi ke terendah
                        usort($hasilRekomendasi, fn($a, $b) => $b['nilai_kemiripan'] <=> $a['nilai_kemiripan']);

                        // Ambil hanya 3 rekomendasi teratas
                        $topRekomendasi = array_slice($hasilRekomendasi, 0, 3);

                        // Cek apakah ada hasil rekomendasi
                        $nilaiTertinggi = count($hasilRekomendasi) > 0 ? max(array_column($hasilRekomendasi, 'nilai_kemiripan')) : 0;
                    @endphp

                    @forelse($topRekomendasi as $index => $hasil)
                        <tr>
                            <td class="fw-bold">{{ $index + 1 }}</td>
                            <td class="fw-bold text-primary">{{ $hasil['kd_kasus_lama'] ?? 'Tidak ada' }}</td>
                            <td>{{ $hasil['nama_prodi'] ?? 'Tidak tersedia' }}</td>
                            <td>{{ $hasil['nilai_kemiripan'] }}</td>
                            <td class="fw-bold">{{ $index + 1 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-danger fw-bold">Tidak ada rekomendasi ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Peringatan jika similarity rendah -->
        @if($nilaiTertinggi < 0.90)
            <div class="alert alert-warning mt-3">
                <p><strong>Mohon maaf</strong>, program studi yang direkomendasikan memiliki kesamaan yang rendah.</p>
                <p>Kasus Anda akan disimpan sebagai <strong>kasus baru</strong> dalam sistem untuk membantu rekomendasi selanjutnya.</p>
            </div>
        @endif

        {{-- <div class="text-center mt-4 mb-5">
            <a href="{{ route('pengguna.beranda') }}" class="btn btn-primary">Kembali ke Beranda</a>
        </div> --}}
    </div>
</body>
</html>
@endsection --}}
