<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PertanyaanKecerdasanModel;
use App\Models\KasusLamaModel;
use App\Models\NormalisasiModel;
use App\Models\BatasThresholdModel;
use App\Models\ProfileKampusModel;
use App\Models\JurusanAsalModel;
use App\Models\KonsultasiModel;
use App\Models\PrestasiModel;
use App\Models\OrganisasiModel;
use App\Models\ReviseModel;
use Illuminate\Support\Facades\Session;
use Log;

class TesController extends Controller
{
    public function index()
    {
        $profile = ProfileKampusModel::first();
        $pertanyaan_kecerdasan = PertanyaanKecerdasanModel::all();
        //  $pertanyaan_kecerdasan = PertanyaanKecerdasanModel::limit(13)->get();

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

        foreach ($jawaban as $id => $nilai) {
            if ($nilai == 1) {
                $pertanyaan = PertanyaanKecerdasanModel::find($id);
                if ($pertanyaan && $pertanyaan->kecerdasan_majemuk) {
                    $jenis = $pertanyaan->kecerdasan_majemuk->nama_kecerdasan;
                    $key = 'kec_' . strtolower(str_replace(' ', '_', $jenis));
                    if (array_key_exists($key, $poinKecerdasan)) {
                        $poinKecerdasan[$key]++;
                        $jawabanDipilih[$key][] = $pertanyaan->pertanyaan;
                    }
                }
            }
        }

        $dataKonsultasi = session('konsultasi');
        if (!$dataKonsultasi) {
            return redirect()->route('pengguna.konsultasi.index')->with('error', 'Isi form konsultasi terlebih dahulu.');
        }

        //dd($dataKonsultasi);
        // Simpan data asli ke kasus_baru
        $konsultasi = KonsultasiModel::create([
            'nama' => $dataKonsultasi['nama'],
            'jurusan_asal' => $dataKonsultasi['jurusan_asal'],
            'organisasi' => $dataKonsultasi['organisasi'],
            'prestasi' => $dataKonsultasi['prestasi'],
            'nilai_rata_rata_rapor' => $dataKonsultasi['nilai_rata_rata_rapor'],
            'kec_linguistik' => $poinKecerdasan['kec_linguistik'],
            'kec_musikal' => $poinKecerdasan['kec_musikal'],
            'kec_logika_matematis' => $poinKecerdasan['kec_logika_matematis'],
            'kec_spasial' => $poinKecerdasan['kec_spasial'],
            'kec_kinestetik' => $poinKecerdasan['kec_kinestetik'],
            'kec_interpersonal' => $poinKecerdasan['kec_interpersonal'],
            'kec_intrapersonal' => $poinKecerdasan['kec_intrapersonal'],
            'kec_naturalis' => $poinKecerdasan['kec_naturalis'],
            'kec_eksistensial' => $poinKecerdasan['kec_eksistensial'],
        ]);

        // Proses indexing ke normalisasi
        $normalisasiBaru = [
            'nilai_rata_rata_rapor' => (float) $dataKonsultasi['nilai_rata_rata_rapor'],
            'jurusan_asal' => JurusanAsalModel::where('nama', $dataKonsultasi['jurusan_asal'])->value('nilai') ?? 0,
            'organisasi' => OrganisasiModel::where('nama', $dataKonsultasi['organisasi'])->value('nilai') ?? 0,
            'prestasi' => PrestasiModel::where('nama', $dataKonsultasi['prestasi'])->value('nilai') ?? 0,
        ];
        foreach ($poinKecerdasan as $key => $val) {
            $normalisasiBaru[$key] = $val;
        }

        $normalisasi = NormalisasiModel::create($normalisasiBaru);

        // Ambil threshold
        $threshold = BatasThresholdModel::first();
        $nilaiThreshold = $threshold ? $threshold->nilai_threshold : 0.90;

        // Ambil semua data normalisasi (kecuali data baru)
        $kasusNormalisasi = NormalisasiModel::where('id', '!=', $normalisasi->id)->whereNotNull('kd_kasus_lama')->get();

        // Hitung cosine similarity
        $hasilRekomendasi = [];
        foreach ($kasusNormalisasi as $kasus) {
            $similarity = $this->cosineSimilarity($normalisasiBaru, $kasus->toArray());
            $namaProdi = $kasus->kasusLama->prodi_by_name->nama_prodi;
            $idProdi = $kasus->kasusLama->prodi_by_name->id_prodi;
            $hasilRekomendasi[] = [
                'kd_kasus_lama' => $kasus->kd_kasus_lama,
                'id_prodi' => $idProdi ?? null,
                'nama_prodi' => $namaProdi ?? '-',
                'nilai_kemiripan' => $similarity,
            ];
        }

        usort($hasilRekomendasi, fn($a, $b) => $b['nilai_kemiripan'] <=> $a['nilai_kemiripan']);
        $top3 = array_slice($hasilRekomendasi, 0, 3);
        $terbaik = $top3[0] ?? null;
        $nilaiTertinggi = $terbaik['nilai_kemiripan'] ?? 0;

        if ($nilaiTertinggi >= $nilaiThreshold) {
            // ✅ Jika similarity cukup → update id_prodi

            // Simpan data asli ke kasus_lama
            $kasusLama = KasusLamaModel::create([
                'nama' => $konsultasi->nama,
                'jurusan_asal' => $konsultasi->jurusan_asal,
                'organisasi' => $konsultasi->organisasi,
                'prestasi' => $konsultasi->prestasi,
                'nilai_rata_rata_rapor' => $konsultasi->nilai_rata_rata_rapor,
                'kec_linguistik' => $konsultasi->kec_linguistik,
                'kec_musikal' => $konsultasi->kec_musikal,
                'kec_logika_matematis' => $konsultasi->kec_logika_matematis,
                'kec_spasial' => $konsultasi->kec_spasial,
                'kec_kinestetik' => $konsultasi->kec_kinestetik,
                'kec_interpersonal' => $konsultasi->kec_interpersonal,
                'kec_intrapersonal' => $konsultasi->kec_intrapersonal,
                'kec_naturalis' => $konsultasi->kec_naturalis,
                'kec_eksistensial' => $konsultasi->kec_eksistensial,
                'nama_prodi' => $terbaik['nama_prodi'],
            ]);


            //Update nama prodi dan kd kasus lama di tabel normalisasi
            $normalisasi->id_prodi = $terbaik['id_prodi'];
            $normalisasi->kd_kasus_lama = $kasusLama->kd_kasus_lama;
            $normalisasi->save();

            $konsultasi->kd_kasus_lama = $kasusLama->kd_kasus_lama;

        } else {
            // ❌ Jika similarity < threshold → pindah ke revise
            $kodeRevise = $this->generateKodeRevise();

            ReviseModel::create(array_merge(
                $konsultasi->toArray(),
                [
                    'similarity' => $nilaiTertinggi,
                    'kd_revise' => $kodeRevise, 
                    'id_prodi' => $terbaik['id_prodi'] ?? null,
                    'nama_prodi' => $terbaik['nama_prodi']
                ]
            ));

            // Hapus dari kasus_lama & normalisasi
            // NormalisasiModel::where('kd_kasus_lama', $kasusBaru->kd_kasus_lama)->delete();
            // $kasusBaru->delete();
        }

        //UPDATE DATA KONSULTASI
        $konsultasi->similarity = $nilaiTertinggi;
        $konsultasi->save();

        session([
            'hasil_rekomendasi' => $top3,
            'poin_kecerdasan' => $poinKecerdasan,
            'jawaban_kecerdasan' => $jawabanDipilih,
        ]);

        return redirect()->route('pengguna.konsultasi.hasil');
    }

    private function cosineSimilarity($a, $b)
    {
        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;

        foreach ($a as $key => $val) {
            if (is_numeric($val) && isset($b[$key]) && is_numeric($b[$key])) {
                $dotProduct += $val * $b[$key];
                $magnitudeA += pow($val, 2);
                $magnitudeB += pow($b[$key], 2);
            }
        }

        if ($magnitudeA == 0 || $magnitudeB == 0) return 0;

        return $dotProduct / (sqrt($magnitudeA) * sqrt($magnitudeB));
    }

    private function generateKodeRevise()
    {
        $last = ReviseModel::latest('id_revise')->first();
        $lastId = $last ? $last->id_revise + 1 : 1;
        return 'RVS-' . str_pad($lastId, 4, '0', STR_PAD_LEFT);
    }
}
