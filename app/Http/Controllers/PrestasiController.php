<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\PrestasiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class PrestasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Prestasi',
            'paragraph' => 'Berikut ini merupakan data prestasi yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.prestasi.index')],
                ['label' => 'Kelola Prestasi'],
            ]
        ];
        
        $activeMenu = 'prestasi';
        $kriteria = KriteriaModel::all();
        
        return view('admin.prestasi.index', ['breadcrumb' => $breadcrumb,'activeMenu' => $activeMenu,'kriteria' => $kriteria]);
    }

    public function list(Request $request)
    {
    $prestasis = PrestasiModel::with('kriteria')
        ->select('prestasi.id_prestasi', 'prestasi.nama', 'prestasi.nilai', 
                'prestasi.created_at', 'prestasi.updated_at', 'prestasi.id_kriteria')
        ->when($request->id_kriteria, function ($query) use ($request) {
            return $query->where('prestasi.id_kriteria', $request->id_kriteria);
        });

    return DataTables::of($prestasis)
        ->addColumn('nama_kriteria', function ($row) {
            return $row->kriteria ? $row->kriteria->nama_kriteria : '-';
        })
        ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Data Prestasi',
            'paragraph' => 'Berikut ini merupakan form tambah data prestasi yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Prestasi', 'url' => route('admin.prestasi.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'prestasi';
    $kriteria = KriteriaModel::all();
    return view('admin.prestasi.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kriteria' => $kriteria]);
    }


    public function store(Request $request)
    { 
        $validatedData = $request->validate([
            'nama'=> 'required|string|unique:prestasi,nama',
            'nilai'=> 'required|integer',
            'id_kriteria'=> 'required|integer',
            
        ]);

        // Menyimpan data ke database
        PrestasiModel::create($validatedData);
        Alert::toast('Data prestasi berhasil ditambahkan', 'success');
        return redirect()->route('admin.prestasi.index')->with('success', 'Data prestasi berhasil ditambahkan');
    }


    public function show($id)
    {
        $prestasi = PrestasiModel::with('kriteria')->find($id);
        if (!$prestasi) {
            return response()->json(['error' => 'Prestasi tidak ditemukan.'], 404);
        }
        $view = view('admin.prestasi.show', compact('prestasi'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit($id)
    {
        $prestasi = PrestasiModel::find($id);
        $kriteria = KriteriaModel::all();

        if (!$prestasi) {
            return redirect()->route('admin.prestasi.index')->with('error', 'Prestasi tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Data Prestasi',
            'paragraph' => 'Berikut ini merupakan form edit data prestasi yang ada di dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Prestasi', 'url' => route('admin.prestasi.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'prestasi';

        return view('admin.prestasi.edit', compact('prestasi', 'kriteria', 'breadcrumb', 'activeMenu'));
    }


    public function update(Request $request, string $id) {
    
        $request->validate([
            'nama'=> 'required|string|unique:prestasi,nama,' . $id . ',id_prestasi',
            'id_kriteria'=> 'required|integer',
            'nilai'=> 'required|integer',
    ]);

    $prestasi = PrestasiModel::find($id);
        $prestasi->update([
            'nama'=> $request->nama,
            'id_kriteria'=> $request->id_kriteria,
            'nilai'=> $request->nilai,
            ]);
            Alert::toast('Data prestasi berhasil diubah', 'success');   
            return redirect()->route('admin.prestasi.index');
        }


        public function destroy($id)
    {
        $prestasi = PrestasiModel::find($id);
        if (!$prestasi) {
            return response()->json([
                'success' => false,
                'message' => 'Data prestasi tidak ditemukan.'
            ], 404);
        }
    
        try {
            $prestasi->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data prestasi berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
            }
        }
    }