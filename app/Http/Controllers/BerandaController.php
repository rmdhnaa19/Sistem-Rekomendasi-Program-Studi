<?php

namespace App\Http\Controllers;

use App\Models\ProfileKampusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BerandaController extends Controller
{
    public function index()
{
    // Ambil data profile kampus pertama
    $profile = ProfileKampusModel::first();

    return view('pengguna.beranda.index', compact('profile'));
    }
}
