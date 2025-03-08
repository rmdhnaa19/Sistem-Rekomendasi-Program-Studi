<?php

namespace App\Http\Controllers;

use App\Models\KecerdasanMajemukModel;
use App\Models\PertanyaanKecerdasanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class PertanyaanKecerdasanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Data Pertanyaan Kecerdasan Majemuk',
            'paragraph' => 'Berikut ini merupakan data pertanyaan kecerdasan majemuk yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.pertanyaan_kecerdasan.index')],
                ['label' => 'Kelola Pertanyaan Kecerdasan'],
            ]
        ];
        
        $activeMenu = 'pertanyaan_kecerdasan';
        $kecerdasan_majemuk= KecerdasanMajemukModel::all();
        
        return view('admin.pertanyaan_kecerdasan.index', ['breadcrumb' => $breadcrumb,'activeMenu' => $activeMenu,'kecerdasan_majemuk' => $kecerdasan_majemuk]);
    }

    public function list(Request $request)
    {
        $pertanyaan_kecerdasans = PertanyaanKecerdasanModel::select('id_pertanyaan_kecerdasan', 'pertanyaan', 'id_kecerdasan_majemuk', 'created_at', 'updated_at')->with('kecerdasan_majemuk'); 
        if ($request->id_kecerdasan_majemuk) {
            $pertanyaan_kecerdasans->where('id_kecerdasan_majemuk', $request->id_kecerdasan_majemuk);
        }
        return DataTables::of($pertanyaan_kecerdasans)->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Data Pertanyaan Kecerdasan',
            'paragraph' => 'Berikut ini merupakan form tambah data pertanyaan kecerdasan yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Pertanyaan Kecerdasan', 'url' => route('admin.pertanyaan_kecerdasan.index')],
                ['label' => 'Tambah'],
            ]
    ];
    $activeMenu = 'pertanyaan_kecerdasan';
    $kecerdasan_majemuk = KecerdasanMajemukModel::all();
    return view('admin.pertanyaan_kecerdasan.create',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'kecerdasan_majemuk' => $kecerdasan_majemuk]);
    }


    public function store(Request $request)
    { 
        $validatedData = $request->validate([
            'pertanyaan'=> 'required|string|unique:pertanyaan_kecerdasan,pertanyaan',
            'id_kecerdasan_majemuk'=> 'required|integer',
        ]);

        // Menyimpan data ke database
        PertanyaanKecerdasanModel::create($validatedData);
        Alert::toast('Data Pertanyaan berhasil ditambahkan', 'success');
        return redirect()->route('admin.pertanyaan_kecerdasan.index')->with('success', 'Data pertanyaan kecerdasan berhasil ditambahkan');
    }


    public function show($id)
    {
        $pertanyaan_kecerdasan = PertanyaanKecerdasanModel::with('kecerdasan_majemuk')->find($id);
        if (!$pertanyaan_kecerdasan) {
            return response()->json(['error' => 'Pertanyaan Keecrdasan tidak ditemukan.'], 404);
        }
        $view = view('admin.pertanyaan_kecerdasan.show', compact('pertanyaan_kecerdasan'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit($id)
    {
        $pertanyaan_kecerdasan = PertanyaanKecerdasanModel::find($id);
        $kecerdasan_majemuk = KecerdasanMajemukModel::all();

        if (!$pertanyaan_kecerdasan) {
            return redirect()->route('admin.pertanyaan_kecerdasan.index')->with('error', 'Pertanyaan kecerdasan tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Data Pertanyaan Kecerdasan',
            'paragraph' => 'Berikut ini merupakan form edit data pertanyaan kecerdasan yang ada di dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Pertanyaan Kecerdasan', 'url' => route('admin.pertanyaan_kecerdasan.index')],
                ['label' => 'Edit'],
            ]
        ];

        $activeMenu = 'pertanyaan_kecerdasan';

        return view('admin.pertanyaan_kecerdasan.edit', compact('pertanyaan_kecerdasan', 'kecerdasan_majemuk', 'breadcrumb', 'activeMenu'));
    }


    public function update(Request $request, string $id) {
    
        $request->validate([
            'pertanyaan'=> 'required|string|unique:pertanyaan_kecerdasan,pertanyaan,' . $id . ',id_pertanyaan_kecerdasan',
            'id_kecerdasan_majemuk'=> 'required|integer',
    ]);

    $pertanyaan_kecerdasan = PertanyaanKecerdasanModel::find($id);
        $pertanyaan_kecerdasan->update([
            'pertanyaan'=> $request->pertanyaan,
            'id_kecerdasan_majemuk'=> $request->id_kecerdasan_majemuk,
            ]);
            Alert::toast('Data pertanyaan kecerdasan berhasil diubah', 'success');   
            return redirect()->route('admin.pertanyaan_kecerdasan.index');
        }


    public function destroy($id)
    {
        $pertanyaan_kecerdasan = PertanyaanKecerdasanModel::find($id);
        if (!$pertanyaan_kecerdasan) {
            return response()->json([
                'success' => false,
                'message' => 'Data pertanyaan kecerdasan tidak ditemukan.'
            ], 404);
        }
    
        try {
            $pertanyaan_kecerdasan->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data pertanyaan kecerdasan berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
            }
        }
    }