<?php

namespace App\Http\Controllers;

use App\Models\ProfileKampusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileKampusController extends Controller
{

    // Menampilkan halaman edit dengan data profile kampus berdasarkan ID
    public function edit()
{
    $profile = ProfileKampusModel::first(); // Tidak perlu cari berdasarkan ID

    if (!$profile) {
        return redirect()->route('dashboard.index')->with('error', 'Data profil kampus tidak ditemukan.');
    }

    $breadcrumb = (object) [
        'title' => 'Edit Profile Kampus',
        'paragraph' => 'Berikut ini merupakan form edit profile kampus',
        'list' => [
            ['label' => 'Home', 'url' => route('dashboard.index')],
            ['label' => 'Kelola Profile Kampus', 'url' => route('profile_kampus.edit')],
            ['label' => 'Edit'],
        ]
    ];

    $activeMenu = 'profileKampus';

    return view('admin.profile_kampus.edit', compact('breadcrumb', 'activeMenu', 'profile'));
}

    // Menyimpan update profile kampus
    public function update(Request $request)
{
    $request->validate([
        'logo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'judul' => 'required|string',
        'deskripsi' => 'required|string',
        'youtube_link' => 'nullable|url',
    ]);

    $profile = ProfileKampusModel::first() ?? new ProfileKampusModel();

    if ($request->hasFile('logo')) {
        if ($profile->logo) {
            Storage::disk('public')->delete($profile->logo);
        }
        $profile->logo = $request->file('logo')->store('logos', 'public');
    }

    $profile->judul = $request->judul;
    $profile->deskripsi = $request->deskripsi;
    $profile->youtube_link = $request->youtube_link;
    $profile->save();

    // Menampilkan SweetAlert dan tetap di halaman edit dengan data terbaru
    Alert::success('Berhasil', 'Profil Kampus berhasil diperbarui!');
    return redirect()->route('profile_kampus.edit'); // Tidak perlu ID
    }
}