<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\OrganisasiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class OrganisasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Organisasi',
            'paragraph' => 'Berikut ini merupakan data organisasi yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.organisasi.index')],
                ['label' => 'Kelola Organisasi'],
            ]
        ];
        
        $activeMenu = 'organisasi';
        $kriteria = KriteriaModel::all();
        
        return view('admin.organisasi.index', ['breadcrumb' => $breadcrumb,'activeMenu' => $activeMenu,'kriteria' => $kriteria]);
    }

    public function list(Request $request)
    {
    $organisasis = OrganisasiModel::with('kriteria')
        ->select('organisasi.id_organisasi', 'organisasi.nama', 'organisasi.nilai', 
                'organisasi.created_at', 'organisasi.updated_at', 'organisasi.id_kriteria')
        ->when($request->id_kriteria, function ($query) use ($request) {
            return $query->where('organisasi.id_kriteria', $request->id_kriteria);
        });

    return DataTables::of($organisasis)
        ->addColumn('nama_kriteria', function ($row) {
            return $row->kriteria ? $row->kriteria->nama_kriteria : '-';
        })
        ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Data Organisasi',
            'paragraph' => 'Berikut ini merupakan form tambah data organisasi yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Organisasi', 'url' => route('admin.organisasi.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'organisasi';
    $kriteria = KriteriaModel::all();
    return view('admin.organisasi.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kriteria' => $kriteria]);
    }


    public function store(Request $request)
    { 
        $validatedData = $request->validate([
            'nama'=> 'required|string|unique:organisasi,nama',
            'nilai'=> 'required|integer',
            'id_kriteria'=> 'required|integer',
            
        ]);

        // Menyimpan data ke database
        OrganisasiModel::create($validatedData);
        Alert::toast('Data organisasi berhasil ditambahkan', 'success');
        return redirect()->route('admin.organisasi.index')->with('success', 'Data organisasi berhasil ditambahkan');
    }


    public function show($id)
    {
        $organisasi = OrganisasiModel::with('kriteria')->find($id);
        if (!$organisasi) {
            return response()->json(['error' => 'Organisasi tidak ditemukan.'], 404);
        }
        $view = view('admin.organisasi.show', compact('organisasi'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit($id)
    {
        $organisasi = OrganisasiModel::find($id);
        $kriteria = KriteriaModel::all();

        if (!$organisasi) {
            return redirect()->route('admin.organisasi.index')->with('error', 'Organisasi tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Data Organisasi',
            'paragraph' => 'Berikut ini merupakan form edit data organisasi yang ada di dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Organisasi', 'url' => route('admin.organisasi.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'organisasi';

        return view('admin.organisasi.edit', compact('organisasi', 'kriteria', 'breadcrumb', 'activeMenu'));
    }


    public function update(Request $request, string $id) {
    
        $request->validate([
            'nama'=> 'required|string|unique:organisasi,nama,' . $id . ',id_organisasi',
            'id_kriteria'=> 'required|integer',
            'nilai'=> 'required|integer',
    ]);

    $organisasi = OrganisasiModel::find($id);
        $organisasi->update([
            'nama'=> $request->nama,
            'id_kriteria'=> $request->id_kriteria,
            'nilai'=> $request->nilai,
            ]);
            Alert::toast('Data organisasiberhasil diubah', 'success');   
            return redirect()->route('admin.organisasi.index');
        }


        public function destroy($id)
    {
        $organisasi = OrganisasiModel::find($id);
        if (!$organisasi) {
            return response()->json([
                'success' => false,
                'message' => 'Data organisasi tidak ditemukan.'
            ], 404);
        }
    
        try {
            $organisasi->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data organisasi berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
            }
        }
    }