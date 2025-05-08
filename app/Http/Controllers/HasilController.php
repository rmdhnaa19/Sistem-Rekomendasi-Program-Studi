<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\ProfileKampusModel;

class HasilController extends Controller
{
    public function index()
    {
        // Ambil data profil untuk navbar
        $profile = ProfileKampusModel::first();

        // View hasil rekomendasi akan akses $profile ini
        return view('pengguna.konsultasi.hasil', compact('profile'));
    }
}
