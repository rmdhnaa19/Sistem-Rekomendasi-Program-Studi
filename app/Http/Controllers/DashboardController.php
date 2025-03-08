<?php

namespace App\Http\Controllers;

use App\Models\JurusanModel;
use App\Models\ProdiModel;
use App\Models\KriteriaModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index(Request $request) {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'paragraph' => 'Berikut ini merupakan visualisasi data yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home'],
            ]
        ];
        $activeMenu = 'dashboard';

        // Total Pengguna,Kriteria, Jurusan, Prodi
        $totalUser = UserModel::count();
        $totalKriteria = KriteriaModel::count();
        $totalProdi = ProdiModel::count();
        $totalJurusan = JurusanModel::count();

        return view('dashboard.index', compact(
            'breadcrumb', 
            'activeMenu',
            'totalUser', 'totalKriteria', 'totalProdi', 'totalJurusan',
        ));
    }
}
