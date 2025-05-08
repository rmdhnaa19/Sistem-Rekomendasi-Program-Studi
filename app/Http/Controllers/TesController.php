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
        $pertanyaan_kecerdasan = PertanyaanKecerdasanModel::all();

        return view('pengguna.konsultasi.tes', compact('profile', 'pertanyaan_kecerdasan'));
    }


    public function store(Request $request)
{
    $request->validate([
        'jawaban' => 'array',
    ]);

    $jawaban = $request->input('jawaban', []);
    $poinKecerdasan = [
        'kec_linguistik' => 0,
        'kec_musikal' => 0,
        'kec_logika_matematis' => 0,
        'kec_spasial' => 0,
        'kec_kinestetik' => 0,
        'kec_interpersonal' => 0,
        'kec_intrapersonal' => 0,
        'kec_naturalis' => 0,
        'kec_eksistensial' => 0,
    ];
    $jawabanDipilih = [];

    foreach ($jawaban as $id_pertanyaan_kecerdasan => $nilai) {
        if ($nilai == 1) {
            $pertanyaan = PertanyaanKecerdasanModel::find($id_pertanyaan_kecerdasan);
            if ($pertanyaan) {
                $jenis = $pertanyaan->kecerdasan_majemuk->nama_kecerdasan;
                $key = 'kec_' . strtolower(str_replace(' ', '_', $jenis));

                if (array_key_exists($key, $poinKecerdasan)) {
                    $poinKecerdasan[$key] += 1;
                    $key = 'kec_' . strtolower(str_replace(' ', '_', $jenis));
                    $jawabanDipilih[$key][] = $pertanyaan->pertanyaan; // teks_pertanyaan
                    
                }
            }
        }
    }
    
    // dd($poinKecerdasan); 
    $dataKonsultasi = session('konsultasi');
    if (!$dataKonsultasi) {
        return redirect()->route('pengguna.konsultasi.index')->with('error', 'Isi form konsultasi terlebih dahulu.');
    }

    $dataKonsultasi['jurusan_asal'] = SubKriteriaModel::where('nama_sub', $dataKonsultasi['jurusan_asal'])->value('nilai') ?? 0;
    $dataKonsultasi['organisasi'] = SubKriteriaModel::where('nama_sub', $dataKonsultasi['organisasi'])->value('nilai') ?? 0;
    $dataKonsultasi['prestasi'] = SubKriteriaModel::where('nama_sub', $dataKonsultasi['prestasi'])->value('nilai') ?? 0;

    $dataBaru = array_merge($dataKonsultasi, $poinKecerdasan);
    $kasusLama = KasusLamaModel::all();
    $hasilRekomendasi = [];

    foreach ($kasusLama as $kasus) {
        $similarity = $this->cosineSimilarity($dataBaru, $kasus->toArray());
        $hasilRekomendasi[] = [
            'kd_kasus_lama' => $kasus->kd_kasus_lama,
            'id_prodi' => $kasus->id_prodi ?? null,
            'nama_prodi' => $kasus->prodi->nama_prodi,
            'nilai_kemiripan' => $similarity
        ];
    }

    usort($hasilRekomendasi, fn($a, $b) => $b['nilai_kemiripan'] <=> $a['nilai_kemiripan']);

    $nilaiTertinggi = $hasilRekomendasi[0]['nilai_kemiripan'] ?? 0;
    $kasusTerbaik = $hasilRekomendasi[0] ?? null;

    if ($nilaiTertinggi == 1) {
        // Jika similarity = 1, tidak perlu retain
    } elseif ($nilaiTertinggi >= 0.90) {
        KasusLamaModel::create(array_merge($dataBaru, [
            'id_prodi' => $kasusTerbaik['id_prodi'] ?? null,
            'nama_prodi' => $kasusTerbaik['nama_prodi']
        ]));
    } else {
        $newKodeRevise = $this->generateKodeRevise();
        $dataBaru['kd_revise'] = $newKodeRevise;

        ReviseModel::create(array_merge($dataBaru, [
            'kd_revise' => $newKodeRevise,
            'id_prodi' => $kasusTerbaik['id_prodi'] ?? null
        ]));
    }

    session([
        'hasil_rekomendasi' => $hasilRekomendasi,
        'poin_kecerdasan' => $poinKecerdasan ?: [],
        'jawaban_kecerdasan' => $jawabanDipilih ?: []
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

    public function hasil()
    {
        $jawabanKecerdasan = session('jawaban_kecerdasan', []);
        $poinKecerdasan = session('poin_kecerdasan', []);
        $hasilRekomendasi = session('hasil_rekomendasi', []);

        // dd($jawabanKecerdasan);

        return view('pengguna.konsultasi.hasil', compact(
            'jawabanKecerdasan',
            'poinKecerdasan',
            'hasilRekomendasi'
        ));
    }

    private function generateKodeRevise()
    {
        $latestRevise = ReviseModel::orderBy('kd_revise', 'desc')->first();
        $newNumber = $latestRevise ? (int) substr($latestRevise->kd_revise, 2) + 1 : 1;
        return 'KB' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
    }
}
