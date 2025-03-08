<?php

namespace App\Http\Controllers;

use App\Models\PagesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PagesController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Kelola Halaman',
            'paragraph' => 'Berikut ini merupakan daftar halaman yang tersedia dalam sistem.',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.pages.index')],
                ['label' => 'Kelola Halaman'],
            ]
        ];
        
        $activeMenu = 'kelolaHalaman';
        $pages = PagesModel::all();
        
        return view('admin.pages.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    // public function list(Request $request)
    // {
    //     $pagess = PagesModel::select('id_pages', 'title', 'slug', 'content');  
    //     if ($request->id_pages) {
    //         $pagess->where('id_pages', $request->id_pages);
    //     }

    //     return DataTables::of($pagess)
    //     ->make(true);
    // }

    public function list(Request $request)
{
    $pages = PagesModel::select('id_pages', 'title', 'slug', 'content');  

    if ($request->id_pages) {
        $pages->where('id_pages', $request->id_pages);
    }

    return DataTables::of($pages)->make(true);
}

    
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Halaman',
            'paragraph' => 'Silakan isi form berikut untuk menambahkan halaman baru.',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Halaman', 'url' => route('admin.pages.index')],
                ['label' => 'Tambah'],
            ]
        ];
        
        $activeMenu = 'kelolaHalaman';
        return view('admin.pages.create', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        PagesModel::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
        ]);

        Alert::toast('Halaman berhasil dibuat!', 'success');
        return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil dibuat!');
    }

    public function show(PagesModel $page) // Gunakan $pages sebagai parameter
    {
        $breadcrumb = (object) [
            'title' => 'Detail Halaman',
            'paragraph' => 'Berikut adalah detail halaman yang dipilih.',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Halaman', 'url' => route('admin.pages.index')],
                ['label' => $page->title], // Gunakan $pages
            ]
        ];
    
        $activeMenu = 'kelolaHalaman';
    
        return view('admin.pages.show', compact('page', 'activeMenu', 'breadcrumb')); // Gunakan $page
    }
    

    public function edit(PagesModel $page) // Gunakan $page
{
    $breadcrumb = (object) [
        'title' => 'Edit Halaman',
        'paragraph' => 'Silakan edit halaman sesuai kebutuhan.',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Halaman', 'url' => route('admin.pages.index')],
            ['label' => 'Edit'],
        ]
    ];

    $activeMenu = 'kelolaHalaman';

    // Debugging untuk cek apakah $page memiliki data
    // dd($page);

    return view('admin.pages.edit', [
        'breadcrumb' => $breadcrumb,
        'activeMenu' => $activeMenu,
        'pages' => $page // Pastikan ini dikirim ke view
    ]);
}


public function update(Request $request, PagesModel $pages)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required',
    ]);

    $pages->update([
        'title' => $request->title,
        // 'slug' => Str::slug($request->title),
        'slug' => 'nullable|string|unique:pages,slug,' . $pages->id,
        'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
        'content' => $request->content,
    ]);

    Alert::toast('Halaman berhasil diperbarui!', 'success');
    return redirect()->route('admin.pages.index')->with('success', 'Halaman berhasil diperbarui!');
}
public function destroy($id)
{
    try {
        $page = PagesModel::findOrFail($id); // Cari data berdasarkan ID
        $page->delete(); // Hapus data

        return response()->json([
            'success' => true,
            'message' => 'Halaman berhasil dihapus.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus halaman: ' . $e->getMessage()
        ], 500);
    }
}
}