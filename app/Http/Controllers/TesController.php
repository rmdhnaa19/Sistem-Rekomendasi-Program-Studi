<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanKecerdasanModel;
use App\Models\JawabanKecerdasanModel;
use App\Models\KecerdasanMajemukModel;
use App\Models\SubKriteriaModel;
use App\Models\ProfileKampusModel;
use App\Models\KasusLamaModel;
use App\Models\ReviseModel;
use Illuminate\Support\Facades\Session;

class TesController extends Controller
{
    public function index(Request $request)
    {
        $profile = ProfileKampusModel::first();
        $perPage = 10;
        $pertanyaan_kecerdasan = PertanyaanKecerdasanModel::paginate($perPage);

        return view('pengguna.konsultasi.tes', compact('profile', 'pertanyaan_kecerdasan'));
    }


    public function store(Request $request)
    {
        // Ambil semua jawaban yang dikirim dari checkbox
        $jawaban = $request->input('pertanyaan', []); // Default kosong jika tidak ada yang dipilih
    
        // Kelompokkan poin berdasarkan jenis kecerdasan
        $poinKecerdasan = [];
        $jawabanDipilih = [];
    
        foreach ($jawaban as $pertanyaan_id => $nilai) {
            if ($nilai == 1) { // Hanya simpan jika pengguna memilih YA
                $pertanyaan = PertanyaanKecerdasanModel::find($pertanyaan_id);
                if ($pertanyaan) {
                    $jenis = $pertanyaan->kecerdasan_majemuk->nama_kecerdasan;
    
                    // Tambahkan 1 poin untuk jenis kecerdasan yang sesuai
                    $poinKecerdasan[$jenis] = ($poinKecerdasan[$jenis] ?? 0) + 1;
    
                    // Simpan pertanyaan yang dipilih
                    $jawabanDipilih[$jenis][] = $pertanyaan->teks_pertanyaan;
                }
            }
        }
    
        // Ambil data konsultasi dari session
        $dataKonsultasi = session('konsultasi');
        if (!$dataKonsultasi) {
            return redirect()->route('pengguna.konsultasi.index')->with('error', 'Isi form konsultasi terlebih dahulu.');
        }
    
        // Konversi jurusan, organisasi, dan prestasi ke nilai indeks dari tabel sub_kriteria
        $dataKonsultasi['jurusan_asal'] = SubKriteriaModel::where('nama_sub', $dataKonsultasi['jurusan_asal'])->value('nilai') ?? 0;
        $dataKonsultasi['organisasi'] = SubKriteriaModel::where('nama_sub', $dataKonsultasi['organisasi'])->value('nilai') ?? 0;
        $dataKonsultasi['prestasi'] = SubKriteriaModel::where('nama_sub', $dataKonsultasi['prestasi'])->value('nilai') ?? 0;
    
        // Gabungkan data konsultasi dengan hasil tes kecerdasan
        $dataBaru = array_merge($dataKonsultasi, $poinKecerdasan);
    
        // Mencari kemiripan dengan kasus lama
        $kasusLama = KasusLamaModel::all();
        $hasilRekomendasi = [];
    
        foreach ($kasusLama as $kasus) {
            $similarity = $this->cosineSimilarity($dataBaru, $kasus);
    
            $hasilRekomendasi[] = [
                'kd_kasus_lama' => $kasus->kode_kasus,
                'nama_prodi' => $kasus->nama_prodi,
                'nilai_kemiripan' => $similarity
            ];
        }
    
        // Urutkan berdasarkan nilai kemiripan tertinggi
        usort($hasilRekomendasi, fn($a, $b) => $b['nilai_kemiripan'] <=> $a['nilai_kemiripan']);
    
        // Ambil nilai similarity tertinggi
        $nilaiTertinggi = $hasilRekomendasi[0]['nilai_kemiripan'] ?? 0;
        $kasusTerbaik = $hasilRekomendasi[0] ?? null;
    
        // Menentukan apakah perlu retain atau revise
        if ($nilaiTertinggi == 1) {
            // Jika similarity = 1, tidak perlu retain
        } elseif ($nilaiTertinggi >= 0.90) {
            // Jika 0.90 ≤ similarity < 1 → retain ke tabel kasus lama
            KasusLamaModel::create(array_merge($dataBaru, ['nama_prodi' => $kasusTerbaik['nama_prodi']])); 
        } else {
            // Jika similarity < 0.90 → simpan ke tabel revise
            $latestRevise = ReviseModel::orderBy('kd_revise', 'desc')->first();
            $newNumber = $latestRevise ? (int)substr($latestRevise->kd_revise, 2) + 1 : 1;
            $newKodeRevise = 'KB' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
            $dataBaru['kd_revise'] = $newKodeRevise;
    
            // Simpan ke tabel revise jika similarity < 0.90
            ReviseModel::create($dataBaru);
        }
    
        // Simpan hasil kecerdasan yang dikirim dari form
        session([
            'hasil_rekomendasi' => $hasilRekomendasi,
            'poin_kecerdasan' => $poinKecerdasan,
            'jawaban_kecerdasan' => $jawabanDipilih
        ]);
    
        return redirect()->route('pengguna.konsultasi.hasil');
    }
    



    private function cosineSimilarity($dataBaru, $kasusLama)
    {
        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;

        foreach ($dataBaru as $key => $value) {
            if (isset($kasusLama[$key])) {
                $dotProduct += (float) $value * (float) $kasusLama[$key];
                $magnitudeA += pow((float) $value, 2);
                $magnitudeB += pow((float) $kasusLama[$key], 2);
            }
        }

        if ($magnitudeA == 0 || $magnitudeB == 0) {
            return 0;
        }

        return $dotProduct / (sqrt($magnitudeA) * sqrt($magnitudeB));
    }
}
