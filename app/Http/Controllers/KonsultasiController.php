<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KonsultasiModel;
use App\Models\ProfileKampusModel;
use App\Models\KasusLamaModel;
use App\Models\KecerdasanMajemukModel;
use App\Models\PertanyaanKecerdasanModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;
use App\Models\JurusanAsalModel; 
use App\Models\PrestasiModel; 
use App\Models\OrganisasiModel;

class KonsultasiController extends Controller
{
    public function index()
{
    $profile = ProfileKampusModel::first();
    $sub_kriteria = SubKriteriaModel::all();
    $pertanyaan_kecerdasan = PertanyaanKecerdasanModel::all();

    $jurusan_asal = JurusanAsalModel::all();
    $prestasi = PrestasiModel::all();
    $organisasi = OrganisasiModel::all();

    return view('pengguna.konsultasi.index', compact(
        'profile', 
        'sub_kriteria', 
        'pertanyaan_kecerdasan',
        'jurusan_asal',
        'prestasi',
        'organisasi'
    ));
}


    // Fungsi create untuk menampilkan form konsultasi
    public function create()
    {
        // Ambil data jurusan, prestasi, dan organisasi
        $jurusan_asal = JurusanAsalModel::all();
        $prestasi = PrestasiModel::all();
        $organisasi = OrganisasiModel::all();

        // Tampilkan form dengan data tersebut
        return view('konsultasi.create', compact('jurusan_asal', 'prestasi', 'organisasi'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'jurusan_asal' => 'required|exists:jurusan_asal,id_jurusan_asal',
            'nilai_rata_rata_rapor' => 'required|numeric',
            'prestasi' => 'required|exists:prestasi,id_prestasi',
            'organisasi' => 'required|exists:organisasi,id_organisasi',
        ]);

        // Ambil nama sub_kriteria yang dipilih
        $jurusanAsal = JurusanAsalModel::where('id_jurusan_asal', $validatedData['jurusan_asal'])->first();
        $prestasi = PrestasiModel::where('id_prestasi', $validatedData['prestasi'])->first();
        $organisasi = OrganisasiModel::where('id_organisasi', $validatedData['organisasi'])->first();

        // Simpan data asli yang dipilih pengguna
        session([ 
            'konsultasi' => [
                'nama' => $validatedData['nama'],
                'jurusan_asal' => $jurusanAsal->nama,
                'nilai_rata_rata_rapor' => $validatedData['nilai_rata_rata_rapor'],
                'prestasi' => $prestasi->nama,
                'organisasi' => $organisasi->nama,
                'jurusan_asal_nilai' => $jurusanAsal->nilai,
                'prestasi_nilai' => $prestasi->nilai,
                'organisasi_nilai' => $organisasi->nilai,
            ]
        ]);

        return redirect()->route('pengguna.tes.index')->with('success', 'Silakan lanjut ke tes kecerdasan.');
    }
}
