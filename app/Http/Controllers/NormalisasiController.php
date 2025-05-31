<?php

namespace App\Http\Controllers;

use App\Models\NormalisasiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert;

class NormalisasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Normalisasi',
            'paragraph' => 'Berikut ini merupakan data normalisasi yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.normalisasi.index')],
                ['label' => 'Kelola Normalisasi'],
            ]
        ];
        
        $activeMenu = 'normalisasi';
        $normalisasi = NormalisasiModel::all();
        
        return view('admin.normalisasi.index', ['breadcrumb' => $breadcrumb,'activeMenu' => $activeMenu,'normalisasi' => $normalisasi]);
    }

    public function list()
{
    $normalisasis = NormalisasiModel::all();

    return DataTables::of($normalisasis)
        ->addIndexColumn()
        ->make(true);
}
}