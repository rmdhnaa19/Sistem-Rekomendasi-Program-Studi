<?php

namespace App\Http\Controllers;

use App\Models\KecerdasanMajemukModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class KecerdasanMajemukController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Kecerdasan Majemuk',
            'paragraph' => 'Berikut ini merupakan data kecerdasan majemuk yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.kecerdasan_majemuk.index')],
                ['label' => 'Kelola Kecerdasan Majemuk'],
            ]
        ];
        $activeMenu = 'kecerdasan_majemuk';
        return view('admin.kecerdasan_majemuk.index',['breadcrumb' =>$breadcrumb,'activeMenu' => $activeMenu]);
    }
    

    public function list(Request $request)
    {
        $kecerdasan_majemuks = KecerdasanMajemukModel::select('id_kecerdasan_majemuk', 'nama_kecerdasan', 'deskripsi');  
        if ($request->id_kecerdasan_majemuk) {
            $kecerdasan_majemuks->where('id_kecerdasan_majemuk', $request->id_kecerdasan_majemuk);
        }
        return DataTables::of($kecerdasan_majemuks)
        ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data Kecerdasan Majemuk',
            'paragraph' => 'Berikut ini merupakan form tambah data kecerdasan majemuk yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Kecerdasan Majemuk', 'url' => route('admin.kecerdasan_majemuk.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'kecerdasan_majemuk';
        $kecerdasan_majemuk = KecerdasanMajemukModel::all();
        return view('admin.kecerdasan_majemuk.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kecerdasan_majemuk' => $kecerdasan_majemuk]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_kecerdasan' => 'required|string|unique:kecerdasan_majemuk,nama_kecerdasan',
            'deskripsi' => 'required|string',            
        ]);

        // Simpan data ke database
        KecerdasanMajemukModel::create($validatedData);
        Alert::toast('Data Jenis Kecerdasan Majemuk berhasil ditambahkan', 'success');
        return redirect()->route('admin.kecerdasan_majemuk.index');
    }

    public function show($id)
    {
        $kecerdasan_majemuk = KecerdasanMajemukModel::find($id);
        if (!$kecerdasan_majemuk) {
            return response()->json(['error' => 'Kecerdasan Majemuk tidak ditemukan.'], 404);
        }
        // Render view dengan data kecerdasan majemuk
        $view = view('admin.kecerdasan_majemuk.show', compact('kecerdasan_majemuk'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit(string $id){
        $kecerdasan_majemuk = KecerdasanMajemukModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Kecerdasan Majemuk',
            'paragraph' => 'Berikut ini merupakan form edit data kecerdasan majemuk yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola Kecerdasan Majemuk', 'url' => route('admin.kecerdasan_majemuk.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'kecerdasan_majemuk';

        return view('admin.kecerdasan_majemuk.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'kecerdasan_majemuk' => $kecerdasan_majemuk]);
    }

    public function update(Request $request, $id)
    {
        $kecerdasan_majemuk = KecerdasanMajemukModel::find($id);
    
        if (!$kecerdasan_majemuk) {
        return redirect()->route('admin.kecerdasan_majemuk.index')->with('error', 'Kecerdasan Majemuk tidak ditemukan');
        }
    
        // Validasi input
        $validatedData = $request->validate([
            'nama_kecerdasan' => 'required|string|unique:kecerdasan_majemuk,nama_kecerdasan,'.$id.',id_kecerdasan_majemuk',
            'deskripsi' => 'required|string',
            ]);
    
            // Update data kecerdasan majemuk
            $kecerdasan_majemuk->update($validatedData);
            Alert::toast('Data Kecerdasan Majemuk berhasil diubah', 'success');
            return redirect()->route('admin.kecerdasan_majemuk.index');
        }


    public function destroy($id)
    {
        $kecerdasan_majemuk = KecerdasanMajemukModel::find($id);
    
        if (!$kecerdasan_majemuk) {
            return response()->json([
                'success' => false,
                'message' => 'Data Kecerdasan Majemuk tidak ditemukan.'
            ], 404);
        }
    
        try {
            $kecerdasan_majemuk->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data kecerdasan majemuk berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
            }
        }
    }

