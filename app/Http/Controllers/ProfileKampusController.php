<?php

namespace App\Http\Controllers;

use App\Models\ProfileKampusModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileKampusController extends Controller
{
    // Menampilkan halaman edit dengan data profile kampus
    public function edit()
    {
        $profile = ProfileKampusModel::first();

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
            'logo_kampus' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'logo_pmb' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'youtube_link' => 'nullable|url',
        ]);

        $profile = ProfileKampusModel::first() ?? new ProfileKampusModel();

        // Handle upload logo kampus (kiri)
        if ($request->hasFile('logo_kampus')) {
            if ($profile->logo_kampus) {
                Storage::disk('public')->delete($profile->logo_kampus);
            }
            $profile->logo_kampus = $request->file('logo_kampus')->store('profile', 'public');
        }

        // Handle upload logo PMB (kanan)
        if ($request->hasFile('logo_pmb')) {
            if ($profile->logo_pmb) {
                Storage::disk('public')->delete($profile->logo_pmb);
            }
            $profile->logo_pmb = $request->file('logo_pmb')->store('profile', 'public');
        }

        $profile->judul = $request->judul;
        $profile->deskripsi = $request->deskripsi;
        $profile->youtube_link = $request->youtube_link;
        $profile->save();

        Alert::success('Berhasil', 'Profil Kampus berhasil diperbarui!');
        return redirect()->route('profile_kampus.edit');
    }
}
