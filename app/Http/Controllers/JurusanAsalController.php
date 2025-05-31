<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\JurusanAsalModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class JurusanAsalController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Jurusan Asal',
            'paragraph' => 'Berikut ini merupakan data jurusan asal yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.jurusan_asal.index')],
                ['label' => 'Kelola Jurusan Asal'],
            ]
        ];
        
        $activeMenu = 'jurusan_asal';
        $kriteria = KriteriaModel::all();
        
        return view('admin.jurusan_asal.index', ['breadcrumb' => $breadcrumb,'activeMenu' => $activeMenu,'kriteria' => $kriteria]);
    }


    public function list(Request $request)
    {
    $jurusan_asals = JurusanAsalModel::with('kriteria')
        ->select('jurusan_asal.id_jurusan_asal', 'jurusan_asal.nama', 'jurusan_asal.nilai', 
                'jurusan_asal.created_at', 'jurusan_asal.updated_at', 'jurusan_asal.id_kriteria')
        ->when($request->id_kriteria, function ($query) use ($request) {
            return $query->where('jurusan_asal.id_kriteria', $request->id_kriteria);
        });

    return DataTables::of($jurusan_asals)
        ->addColumn('nama_kriteria', function ($row) {
            return $row->kriteria ? $row->kriteria->nama_kriteria : '-';
        })
        ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Data Jurusan Asal',
            'paragraph' => 'Berikut ini merupakan form tambah data jurusan asal yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Jurusan Asal', 'url' => route('admin.jurusan_asal.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'jurusan_asal';
    $kriteria = KriteriaModel::all();
    return view('admin.jurusan_asal.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kriteria' => $kriteria]);
    }


    public function store(Request $request)
    { 
        $validatedData = $request->validate([
            'nama'=> 'required|string|unique:jurusan_asal,nama',
            'nilai'=> 'required|integer',
            'id_kriteria'=> 'required|integer',
            
        ]);

        // Menyimpan data ke database
        JurusanAsalModel::create($validatedData);
        Alert::toast('Data jurusan asal berhasil ditambahkan', 'success');
        return redirect()->route('admin.jurusan_asal.index')->with('success', 'Data jurusan asal berhasil ditambahkan');
    }


    public function show($id)
    {
        $jurusan_asal = JurusanAsalModel::with('kriteria')->find($id);
        if (!$jurusan_asal) {
            return response()->json(['error' => 'Jurusan asal tidak ditemukan.'], 404);
        }
        $view = view('admin.jurusan_asal.show', compact('jurusan_asal'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit($id)
    {
        $jurusan_asal = JurusanAsalModel::find($id);
        $kriteria = KriteriaModel::all();

        if (!$jurusan_asal) {
            return redirect()->route('admin.jurusan_asal.index')->with('error', 'Jurusan asal tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Data Jurusan Asal',
            'paragraph' => 'Berikut ini merupakan form edit data jurusan asal yang ada di dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Jurusan Asal', 'url' => route('admin.jurusan_asal.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'jurusan_asal';

        return view('admin.jurusan_asal.edit', compact('jurusan_asal', 'kriteria', 'breadcrumb', 'activeMenu'));
    }


    public function update(Request $request, string $id) {
    
        $request->validate([
            'nama'=> 'required|string|unique:jurusan_asal,nama,' . $id . ',id_jurusan_asal',
            'id_kriteria'=> 'required|integer',
            'nilai'=> 'required|integer',
    ]);

    $jurusan_asal = JurusanAsalModel::find($id);
        $jurusan_asal->update([
            'nama'=> $request->nama,
            'id_kriteria'=> $request->id_kriteria,
            'nilai'=> $request->nilai,
            ]);
            Alert::toast('Data jurusan asal berhasil diubah', 'success');   
            return redirect()->route('admin.jurusan_asal.index');
        }


        public function destroy($id)
    {
        $jurusan_asal = JurusanAsalModel::find($id);
        if (!$jurusan_asal) {
            return response()->json([
                'success' => false,
                'message' => 'Data jurusan asal tidak ditemukan.'
            ], 404);
        }
    
        try {
            $jurusan_asal->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data jurusan asal berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
            }
        }
    }