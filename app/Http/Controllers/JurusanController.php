<?php

namespace App\Http\Controllers;

use App\Models\JurusanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class JurusanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Jurusan',
            'paragraph' => 'Berikut ini merupakan data jurusan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.jurusan.index')],
                ['label' => 'Kelola Jurusan'],
            ]
        ];
        $activeMenu = 'jurusan';
        return view('admin.jurusan.index',['breadcrumb' =>$breadcrumb,'activeMenu' => $activeMenu]);
    }
    

    public function list(Request $request)
    {
        $jurusans = JurusanModel::select('id_jurusan', 'nama_jurusan', 'deskripsi');  
        if ($request->id_jurusan) {
            $jurusans->where('id_jurusan', $request->id_jurusan);
        }
        return DataTables::of($jurusans)
        ->make(true);
    }


    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Jurusan',
            'paragraph' => 'Berikut ini merupakan form tambah data jurusan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Jurusan', 'url' => route('admin.jurusan.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'jurusan';
        $jurusan = JurusanModel::all();
        return view('admin.jurusan.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'jurusan' => $jurusan]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_jurusan' => 'required|string|unique:jurusan,nama_jurusan',
            'deskripsi' => 'required|string',            
        ]);

        // Simpan data ke database
        JurusanModel::create($validatedData);
        Alert::toast('Data jurusan berhasil ditambahkan', 'success');
        return redirect()->route('admin.jurusan.index');
    }

    public function show($id)
    {
        $jurusan = JurusanModel::find($id);
        if (!$jurusan) {
            return response()->json(['error' => 'Jurusan tidak ditemukan.'], 404);
        }
        // Render view dengan data jurusan
        $view = view('admin.jurusan.show', compact('jurusan'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit(string $id){
        $jurusan = JurusanModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Jurusan',
            'paragraph' => 'Berikut ini merupakan form edit data jurusan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Jurusan', 'url' => route('admin.jurusan.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'jurusan';

        return view('admin.jurusan.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'jurusan' => $jurusan]);
    }

    public function update(Request $request, $id)
    {
        $jurusan = JurusanModel::find($id);
    
        if (!$jurusan) {
        return redirect()->route('admin.jurusan.index')->with('error', 'Jurusan tidak ditemukan');
        }
    
        // Validasi input
        $validatedData = $request->validate([
            'nama_jurusan' => 'required|string|unique:jurusan,nama_jurusan,'.$id.',id_jurusan',
            'deskripsi' => 'required|string',
            ]);
    
            // Update data jurusan
            $jurusan->update($validatedData);
            Alert::toast('Data Jurusan berhasil diubah', 'success');
            return redirect()->route('admin.jurusan.index');
        }

    public function destroy($id)
    {
        $jurusan = JurusanModel::find($id);
    
        if (!$jurusan) {
            return response()->json([
                'success' => false,
                'message' => 'Data Jurusan tidak ditemukan.'
            ], 404);
        }
    
        try {
            $jurusan->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Jurusan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
            }
        }
    }