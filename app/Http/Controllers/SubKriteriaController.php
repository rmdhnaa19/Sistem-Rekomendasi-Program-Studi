<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\SubKriteriaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class SubKriteriaController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Sub Kriteria',
            'paragraph' => 'Berikut ini merupakan data sub kriteria yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.sub_kriteria.index')],
                ['label' => 'Kelola Sub Kriteria'],
            ]
        ];
        
        $activeMenu = 'sub_kriteria';
        $kriteria = KriteriaModel::all();
        
        return view('admin.sub_kriteria.index', ['breadcrumb' => $breadcrumb,'activeMenu' => $activeMenu,'kriteria' => $kriteria]);
    }

    // public function list(Request $request)
    // {
    //     $sub_kriterias = SubKriteriaModel::select('id_sub_kriteria', 'nama_sub', 'nilai', 'created_at', 'updated_at')->with('kriteria'); 
    //     if ($request->id_kriteria) {
    //         $sub_kriterias->where('id_kriteria', $request->id_kriteria);
    //     }
    //     return DataTables::of($sub_kriterias)->make(true);
    // }

    public function list(Request $request)
    {
    $sub_kriterias = SubKriteriaModel::with('kriteria')
        ->select('sub_kriteria.id_sub_kriteria', 'sub_kriteria.nama_sub', 'sub_kriteria.nilai', 
                'sub_kriteria.created_at', 'sub_kriteria.updated_at', 'sub_kriteria.id_kriteria')
        ->when($request->id_kriteria, function ($query) use ($request) {
            return $query->where('sub_kriteria.id_kriteria', $request->id_kriteria);
        });

    return DataTables::of($sub_kriterias)
        ->addColumn('nama_kriteria', function ($row) {
            return $row->kriteria ? $row->kriteria->nama_kriteria : '-';
        })
        ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Data Sub Kriteria',
            'paragraph' => 'Berikut ini merupakan form tambah data sub kriteria yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Sub Kriteria', 'url' => route('admin.sub_kriteria.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'sub_kriteria';
    $kriteria = KriteriaModel::all();
    return view('admin.sub_kriteria.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kriteria' => $kriteria]);
    }


    public function store(Request $request)
    { 
        $validatedData = $request->validate([
            'nama_sub'=> 'required|string|unique:sub_kriteria,nama_sub',
            'nilai'=> 'required|integer',
            'id_kriteria'=> 'required|integer',
            
        ]);

        // Menyimpan data ke database
        SubKriteriaModel::create($validatedData);
        Alert::toast('Data Sub Kriteria berhasil ditambahkan', 'success');
        return redirect()->route('admin.sub_kriteria.index')->with('success', 'Data program studi berhasil ditambahkan');
    }


    public function show($id)
    {
        $sub_kriteria = SubKriteriaModel::with('kriteria')->find($id);
        if (!$sub_kriteria) {
            return response()->json(['error' => 'Sub Kriteria tidak ditemukan.'], 404);
        }
        $view = view('admin.sub_kriteria.show', compact('sub_kriteria'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit($id)
    {
        $sub_kriteria = SubKriteriaModel::find($id);
        $kriteria = KriteriaModel::all();

        if (!$sub_kriteria) {
            return redirect()->route('admin.sub_kriteria.index')->with('error', 'Sub kriteria tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Data Sub Kriteria',
            'paragraph' => 'Berikut ini merupakan form edit data sub kriteria yang ada di dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kasus Lama', 'url' => route('admin.sub_kriteria.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'sub_kriteria';

        return view('admin.sub_kriteria.edit', compact('sub_kriteria', 'kriteria', 'breadcrumb', 'activeMenu'));
    }


    public function update(Request $request, string $id) {
    
        $request->validate([
            'nama_sub'=> 'required|string|unique:sub_kriteria,nama_sub,' . $id . ',id_sub_kriteria',
            'id_kriteria'=> 'required|integer',
            'nilai'=> 'required|integer',
    ]);

    $sub_kriteria = SubKriteriaModel::find($id);
        $sub_kriteria->update([
            'nama_sub'=> $request->nama_sub,
            'id_kriteria'=> $request->id_kriteria,
            'nilai'=> $request->nilai,
            ]);
            Alert::toast('Data Sub kriteria berhasil diubah', 'success');   
            return redirect()->route('admin.sub_kriteria.index');
        }


        public function destroy($id)
    {
        $sub_kriteria = SubKriteriaModel::find($id);
        if (!$sub_kriteria) {
            return response()->json([
                'success' => false,
                'message' => 'Data sub kriteria tidak ditemukan.'
            ], 404);
        }
    
        try {
            $sub_kriteria->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data sub kriteria berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
            }
        }
    }