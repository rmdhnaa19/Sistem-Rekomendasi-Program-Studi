<?php

namespace App\Http\Controllers;

use App\Models\JurusanModel;
use App\Models\ProdiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class ProdiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Program Studi',
            'paragraph' => 'Berikut ini merupakan data program studi yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.prodi.index')],
                ['label' => 'Kelola Program Studi'],
            ]
        ];
        
        $activeMenu = 'prodi';
        $jurusan = JurusanModel::all();
        
        return view('admin.prodi.index', ['breadcrumb' => $breadcrumb,'activeMenu' => $activeMenu,'jurusan' => $jurusan]);
    }

    public function list(Request $request)
    {
        $prodis = ProdiModel::select('id_prodi', 'nama_prodi', 'id_jurusan', 'akreditasi', 'jenjang', 'durasi_studi', 'deskripsi', 'created_at', 'updated_at')->with('jurusan'); 
        if ($request->id_jurusan) {
            $prodis->where('id_jurusan', $request->id_jurusan);
        }
        return DataTables::of($prodis)->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Data Program Studi',
            'paragraph' => 'Berikut ini merupakan form tambah data program studi yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Prodi', 'url' => route('admin.prodi.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'prodi';
    $jurusan = JurusanModel::all();
    return view('admin.prodi.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'jurusan' => $jurusan]);
    }


    public function store(Request $request)
    { 
        $validatedData = $request->validate([
            'nama_prodi'=> 'required|string|unique:prodi,nama_prodi',
            'id_jurusan'=> 'required|integer',
            'akreditasi'=> 'required|string',
            'jenjang'=>'required|string',
            'durasi_studi'=> 'required|string',
            'deskripsi'=> 'required|string',
        ]);

        // Menyimpan data ke database
        ProdiModel::create($validatedData);
        Alert::toast('Data Prodi berhasil ditambahkan', 'success');
        return redirect()->route('admin.prodi.index')->with('success', 'Data program studi berhasil ditambahkan');
    }


    public function show($id)
    {
        $prodi = ProdiModel::with('jurusan')->find($id);
        if (!$prodi) {
            return response()->json(['error' => 'Program Studi tidak ditemukan.'], 404);
        }
        $view = view('admin.prodi.show', compact('prodi'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit($id)
    {
        $prodi = ProdiModel::find($id);
        $jurusan = JurusanModel::all();

        if (!$prodi) {
            return redirect()->route('admin.prodi.index')->with('error', 'Program Studi tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Data Program Studi',
            'paragraph' => 'Berikut ini merupakan form edit data program studi yang ada di dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Prodi', 'url' => route('admin.prodi.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'prodi';

        return view('admin.prodi.edit', compact('prodi', 'jurusan', 'breadcrumb', 'activeMenu'));
    }


    public function update(Request $request, string $id) {
    
        $request->validate([
            'nama_prodi'=> 'required|string|unique:prodi,nama_prodi,' . $id . ',id_prodi',
            'id_jurusan'=> 'required|integer',
            'akreditasi'=> 'required|string',
            'jenjang'=>'required|string',
            'durasi_studi'=> 'required|string',
            'deskripsi'=> 'required|string',
    ]);

    $prodi = ProdiModel::find($id);
        $prodi->update([
            'nama_prodi'=> $request->nama_prodi,
            'id_jurusan'=> $request->id_jurusan,
            'akreditasi'=> $request->akreditasi,
            'jenjang'=> $request->jenjang,
            'durasi_studi'=> $request->durasi_studi,
            'deskripsi'=> $request->deskripsi,
            ]);
            Alert::toast('Data Program Studi berhasil diubah', 'success');   
            return redirect()->route('admin.prodi.index');
        }


        public function destroy($id)
    {
        $prodi = ProdiModel::find($id);
        if (!$prodi) {
            return response()->json([
                'success' => false,
                'message' => 'Data Program Studi tidak ditemukan.'
            ], 404);
        }
    
        try {
            $prodi->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Program Studi berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
            }
        }
    }