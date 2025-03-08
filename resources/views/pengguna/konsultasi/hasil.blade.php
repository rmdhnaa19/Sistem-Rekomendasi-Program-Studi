<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hasil Rekomendasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
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


        <!-- Menampilkan hasil tes kecerdasan -->
        @foreach(session('jawaban_kecerdasan', []) as $jenisKecerdasan => $pertanyaan)
        <h3>Kecerdasan {{ $jenisKecerdasan }}:</h3>
        <ul>
            @foreach($pertanyaan as $pertanyaanItem)
                <li>{{ $pertanyaanItem }}</li>
            @endforeach
        </ul>
        <p>Total poin: {{ session('poin_kecerdasan')[$jenisKecerdasan] ?? 0 }}</p>
        @endforeach


        <!-- Tabel Hasil Rekomendasi -->
        <h4 class="fw-bold text-center">Rekomendasi Program Studi</h4>
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
                @endphp

                @forelse($hasilRekomendasi as $index => $hasil)
                    <tr>
                        <td class="fw-bold">{{ $index + 1 }}</td>
                        <td class="fw-bold text-primary">{{ $hasil['kd_kasus_lama'] }}</td>
                        <td>{{ $hasil['nama_prodi'] }}</td>
                        <td>{{ number_format($hasil['nilai_kemiripan'], 2) }}</td>
                        <td class="fw-bold">{{ $index + 1 }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-danger fw-bold">Tidak ada rekomendasi ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Peringatan jika similarity rendah -->
        @php $nilaiTertinggi = count($hasilRekomendasi) > 0 ? max(array_column($hasilRekomendasi, 'nilai_kemiripan')) : 0; @endphp
        @if($nilaiTertinggi < 0.90)
            <div class="alert alert-warning mt-3">
                <p><strong>Mohon maaf</strong>, program studi yang direkomendasikan memiliki kesamaan yang rendah.</p>
                <p>Kasus Anda akan disimpan sebagai <strong>kasus baru</strong> dalam sistem untuk membantu rekomendasi selanjutnya.</p>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('pengguna.beranda') }}" class="btn btn-primary">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
