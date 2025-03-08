<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;


class KriteriaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Kriteria',
            'paragraph' => 'Berikut ini merupakan data kriteria yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.kriteria.index')],
                ['label' => 'Kelola Kriteria'],
            ]
        ];
        $activeMenu = 'kriteria';
        return view('admin.kriteria.index',['breadcrumb' =>$breadcrumb,'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $kriterias = KriteriaModel::select('id_kriteria', 'jenis_kriteria', 'nama_kriteria');  
        if ($request->id_kriteria) {
            $kriterias->where('id_kriteria', $request->id_kriteria);
        }
        return DataTables::of($kriterias)
        ->make(true);
    }

    public function create()
{
    $breadcrumb = (object) [
        'title' => 'Tambah Data Kriteria',
        'paragraph' => 'Berikut ini merupakan form tambah data kriteria yang terinput ke dalam sistem',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Kelola Kriteria', 'url' => route('admin.kriteria.index')],
            ['label' => 'Tambah'],
        ]
    ];
    $activeMenu = 'kriteria';

    // Ambil nilai enum dari kolom jenis_kriteria
    $jenis_kriteria = \DB::select("SHOW COLUMNS FROM kriteria LIKE 'jenis_kriteria'");
    $enum_values = [];

    if (!empty($jenis_kriteria)) {
        $type = $jenis_kriteria[0]->Type;
        preg_match("/^enum\((.*)\)$/", $type, $matches);
        $enum_values = array_map(function ($value) {
            return trim($value, "'");
        }, explode(',', $matches[1]));
    }

    return view('admin.kriteria.create', [
        'breadcrumb' => $breadcrumb,
        'activeMenu' => $activeMenu,
        'enum_values' => $enum_values // Kirim data enum ke view
    ]);
}


    public function store(Request $request)
    { 
        $validatedData = $request->validate([
            'jenis_kriteria' => 'required|in:kualitatif,kuantitatif',
            'nama_kriteria'  => 'required|string|max:50',
        ]);

        // Menyimpan data ke database
        KriteriaModel::create($validatedData);
        Alert::toast('Data kriteria berhasil ditambahkan', 'success');
        return redirect()->route('admin.kriteria.index')->with('success', 'Data kriteria berhasil ditambahkan');
    }

    public function show($id)
    {
        $kriteria = KriteriaModel::find($id);
        if (!$kriteria) {
            return response()->json(['error' => 'Kriteria tidak ditemukan.'], 404);
        }
        // Render view dengan data jurusan
        $view = view('admin.kriteria.show', compact('kriteria'))->render();
        return response()->json(['html' => $view]);
    }

    public function edit(string $id){
        $kriteria = KriteriaModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Kriteria',
            'paragraph' => 'Berikut ini merupakan form edit data kriteria yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Kriteria', 'url' => route('admin.kriteria.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'kriteria';

        return view('admin.kriteria.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'kriteria' => $kriteria]);
    }

    public function update(Request $request, $id)
    {
        $kriteria = KriteriaModel::find($id);
    
        if (!$kriteria) {
        return redirect()->route('admin.kriteria.index')->with('error', 'Kriteria tidak ditemukan');
        }
    
        // Validasi input
        $validatedData = $request->validate([
            'jenis_kriteria' => 'required|in:kualitatif,kuantitatif',
            'nama_kriteria' => 'required|string',
            ]);
    
            // Update data jurusan
            $kriteria->update($validatedData);
            Alert::toast('Data kriteria berhasil diubah', 'success');
            return redirect()->route('admin.kriteria.index');
        }

    public function destroy($id)
    {
        $kriteria = KriteriaModel::find($id);
    
        if (!$kriteria) {
            return response()->json([
                'success' => false,
                'message' => 'Data kriteria tidak ditemukan.'
            ], 404);
        }
    
        try {
            $kriteria->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data kriteria berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
            }
        }
}
