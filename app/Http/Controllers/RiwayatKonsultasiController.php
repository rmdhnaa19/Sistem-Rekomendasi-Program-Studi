<?php

namespace App\Http\Controllers;

use App\Models\KecerdasanMajemukModel;
use App\Models\KonsultasiModel;
use App\Models\NormalisasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class RiwayatKonsultasiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Riwayat User Konsultasi',
            'paragraph' => 'Berikut ini merupakan data riwayat user konsultasi yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('admin.riwayat-konsultasi.index')],
                ['label' => 'Riwayat User Konsultasi'],
            ]
        ];
        $activeMenu = 'riwayat-konsultasi';
        return view('admin.riwayat.index',['breadcrumb' =>$breadcrumb,'activeMenu' => $activeMenu]);
    }
    

    public function list(Request $request)
    {
        $data = KonsultasiModel::with('kasusLama')->select('*')->selectRaw('date_format(created_at,"%d %M %Y - %H:%i WIB") as tanggal');
        return DataTables::of($data)
        ->editColumn('nama_prodi', function($query)
        {
            return $query->kasusLama?->nama_prodi ;
        })
        ->make(true);
    }
}

