<?php

namespace App\Http\Controllers;

use App\Models\ReviseModel;
use App\Models\KasusLamaModel;
use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ReviseController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Kasus Revisi',
            'paragraph' => 'Berikut ini merupakan data kasus baru yang memiliki similarity score < 0,90',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Revise'],
            ]
        ];
        $activeMenu = 'revise';
        $revise = ReviseModel::with(['prodi'])->get();
    
        return view('admin.revise.index', compact('breadcrumb', 'activeMenu', 'revise'));
    }

    public function list(Request $request)
{
    $revises = ReviseModel::select(
        'id_revise',
        'kd_revise',
        'nama',
        'jurusan_asal',
        'nilai_rata_rata_rapor',
        'prestasi',
        'organisasi',
        'kec_linguistik',
        'kec_musikal',
        'kec_logika_matematis',
        'kec_spasial',
        'kec_kinestetik',
        'kec_interpersonal',
        'kec_intrapersonal',
        'kec_naturalis',
        'kec_eksistensial',
        'id_prodi',
        'status', 
        'created_at', 
        'updated_at'
    )->with('prodi');

    if ($request->id_prodi) {
        $revises->where('id_prodi', $request->id_prodi);
    }

    return DataTables::of($revises)
        // Ganti kolom asli dengan kolom yang berisi nama_sub
        ->editColumn('jurusan_asal', function ($row) {
            $subKriteria = SubKriteriaModel::where('id_sub_kriteria', $row->jurusan_asal)->first();
            return $subKriteria ? $subKriteria->nama_sub : '-';
        })
        ->editColumn('prestasi', function ($row) {
            $subKriteria = SubKriteriaModel::where('id_sub_kriteria', $row->prestasi)->first();
            return $subKriteria ? $subKriteria->nama_sub : '-';
        })
        ->editColumn('organisasi', function ($row) {
            $subKriteria = SubKriteriaModel::where('id_sub_kriteria', $row->organisasi)->first();
            return $subKriteria ? $subKriteria->nama_sub : '-';
        })
        ->addColumn('prodi_nama', function ($row) {
            return $row->prodi ? $row->prodi->nama_prodi : '-';
        })
        ->rawColumns(['jurusan_asal', 'prestasi', 'organisasi', 'prodi_nama'])
        ->make(true);
}  


public function show($id)
{
    $revise = ReviseModel::with('prodi')->find($id);
    
    if (!$revise) {
        return response()->json(['error' => 'Kasus baru tidak ditemukan.'], 404);
    }

    $view = view('admin.revise.show', compact('revise'))->render();
    return response()->json(['html' => $view]);
}

public function edit($id)
    {
        $revise = ReviseModel::where('id_revise', $id)->first();
        $kriteria = [
            'jurusan_asal' => SubKriteriaModel::where('id_kriteria', 16)->pluck('nama_sub', 'id_sub_kriteria')->toArray(),
            'Prestasi' => SubKriteriaModel::where('id_kriteria', 19)->pluck('nama_sub', 'id_sub_kriteria')->toArray(),
            'Keaktifan Organisasi' => SubKriteriaModel::where('id_kriteria', 20)->pluck('nama_sub', 'id_sub_kriteria')->toArray(),
        ];        
        $sub_kriteria = SubKriteriaModel::all();
        $list_prodi = ProdiModel::all();

        if (!$revise) {
            return redirect()->route('admin.revise.index')->with('error', 'Kasus baru tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Data Kasus Baru',
            'paragraph' => 'Berikut ini merupakan form edit data kasus baru yang memiliki similarity score < 0,90',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kasus Baru', 'url' => route('admin.revise.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'revise';

        return view('admin.revise.edit', compact('revise', 'list_prodi', 'sub_kriteria', 'kriteria', 'breadcrumb', 'activeMenu'));
    }


    public function update(Request $request, $id)
{
    // dd($request->all());
    $revise = ReviseModel::where('id_revise', $id)->firstOrFail();

    $validatedData = $request->validate([
        'nama' => 'required|string|max:50',
        'jurusan_asal' => 'required|string',
        'nilai_rata_rata_rapor' => 'required|numeric|min:0|max:100',
        'prestasi' => 'required|string',
        'organisasi' => 'required|string',
        'kec_linguistik' => 'required|integer|min:0',
        'kec_musikal' => 'required|integer|min:0',
        'kec_logika_matematis' => 'required|integer|min:0',
        'kec_spasial' => 'required|integer|min:0',
        'kec_kinestetik' => 'required|integer|min:0',
        'kec_interpersonal' => 'required|integer|min:0',
        'kec_intrapersonal' => 'required|integer|min:0',
        'kec_naturalis' => 'required|integer|min:0',
        'kec_eksistensial' => 'required|integer|min:0',
        'id_prodi' => 'required|integer',
        'status' => 'required|string',
    ]);

    // Update data
    $revise->update($validatedData);

    Alert::toast('Data Kasus Baru berhasil diperbarui', 'success');
    return redirect()->route('admin.revise.index');
}

public function approve($id)
{
    $revise = ReviseModel::findOrFail($id);

    // Ambil kode kasus terakhir dari tabel kasus_lama
    $lastCase = KasusLamaModel::orderByRaw("LENGTH(kd_kasus_lama) DESC, kd_kasus_lama DESC")->first();

    // Tentukan kode kasus baru
    if ($lastCase) {
        // Ambil angka dari kode terakhir, misal KL01 -> 01 atau KL100 -> 100
        $lastNumber = (int) substr($lastCase->kd_kasus_lama, 2);
        $newNumber = $lastNumber + 1;
        $newKdKasus = "KL" . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
    } else {
        // Jika belum ada data, mulai dari KL01
        $newKdKasus = "KL01";
    }

    // Pindahkan data ke tabel kasus_lama
    KasusLamaModel::create([
        'kd_kasus_lama' => $newKdKasus, // Gunakan kode baru dengan format KL
        'nama' => $revise->nama,
        'jurusan_asal' => $revise->jurusan_asal,
        'nilai_rata_rata_rapor' => $revise->nilai_rata_rata_rapor,
        'prestasi' => $revise->prestasi,
        'organisasi' => $revise->organisasi,
        'kec_linguistik' => $revise->kec_linguistik,
        'kec_musikal' => $revise->kec_musikal,
        'kec_logika_matematis' => $revise->kec_logika_matematis,
        'kec_spasial' => $revise->kec_spasial,
        'kec_kinestetik' => $revise->kec_kinestetik,
        'kec_interpersonal' => $revise->kec_interpersonal,
        'kec_intrapersonal' => $revise->kec_intrapersonal,
        'kec_naturalis' => $revise->kec_naturalis,
        'kec_eksistensial' => $revise->kec_eksistensial,
        'id_prodi' => $revise->id_prodi,
    ]);

    // Hapus dari tabel revise setelah dipindahkan
    $revise->delete();

    return response()->json(['message' => 'Kasus berhasil disetujui dan dipindahkan ke kasus lama dengan kode ' . $newKdKasus]);
}


    public function destroy($id)
    {
        $revise = ReviseModel::where('id_revise', $id)->first();
    
        if (!$revise) {
            return response()->json([
                'success' => false,
                'message' => 'Data kasus baru tidak ditemukan.'
            ], 404);
        }
    
        try {
            $revise->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data kasus baru berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
            }
        }
}
