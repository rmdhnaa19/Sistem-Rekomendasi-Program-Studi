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

class KonsultasiController extends Controller
{
    public function index()
{
    $profile = ProfileKampusModel::first();
    $sub_kriteria = SubKriteriaModel::all();
    $pertanyaan_kecerdasan = PertanyaanKecerdasanModel::all();

    // Ambil sub_kriteria berdasarkan id_kriteria tertentu
    $sub_kriteria_jurusan = SubKriteriaModel::where('id_kriteria', 16)->get(); 
    $sub_kriteria_prestasi = SubKriteriaModel::where('id_kriteria', 19)->get(); 
    $sub_kriteria_organisasi = SubKriteriaModel::where('id_kriteria', 20)->get();

    return view('pengguna.konsultasi.index', compact(
        'profile', 
        'sub_kriteria', 
        'pertanyaan_kecerdasan',
        'sub_kriteria_jurusan',
        'sub_kriteria_prestasi',
        'sub_kriteria_organisasi'
    ));
}


// public function tes()
// {
//     return view('pengguna.konsultasi.tes');
// }

public function store(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'nama' => 'required|string',
        'jurusan_asal' => 'required|exists:sub_kriteria,id_sub_kriteria',
        'nilai_rata_rata_rapor' => 'required|numeric',
        'prestasi' => 'required|exists:sub_kriteria,id_sub_kriteria',
        'organisasi' => 'required|exists:sub_kriteria,id_sub_kriteria',
    ]);

    // Ambil nama sub_kriteria yang dipilih
    $jurusanAsal = SubKriteriaModel::where('id_sub_kriteria', $validatedData['jurusan_asal'])->first();
    $prestasi = SubKriteriaModel::where('id_sub_kriteria', $validatedData['prestasi'])->first();
    $organisasi = SubKriteriaModel::where('id_sub_kriteria', $validatedData['organisasi'])->first();

    // Simpan data asli yang dipilih pengguna
    session([
        'konsultasi' => [
            'nama' => $validatedData['nama'],
            'jurusan_asal' => $jurusanAsal->nama_sub,  
            'nilai_rata_rata_rapor' => $validatedData['nilai_rata_rata_rapor'],
            'prestasi' => $prestasi->nama_sub,  
            'organisasi' => $organisasi->nama_sub,  
            'jurusan_asal_nilai' => $jurusanAsal->nilai, 
            'prestasi_nilai' => $prestasi->nilai, 
            'organisasi_nilai' => $organisasi->nilai,
        ]
    ]);

    return redirect()->route('pengguna.tes.index')->with('success', 'Silakan lanjut ke tes kecerdasan.');
}
}