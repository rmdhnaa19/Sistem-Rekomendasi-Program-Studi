<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class EditProfileController extends Controller
{
    public function edit(string $id) {
        $breadcrumb = (object) [
            'title' => 'Edit Profil User',
            'paragraph' => 'Berikut ini merupakan edit profil user',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Edit Profil User'],
            ]
        ];
        if (Auth::id() != $id) {
            abort(403, 'Unauthorized action.');
        }
        $activeMenu = '';

        $user = Auth::user();
        return view('profile.edit', compact('breadcrumb', 'user', 'activeMenu'));
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nama' => 'required|string|unique:user,nama,'.$id.',id_user',
            'username' => 'required|string|unique:user,username,'.$id.',id_user',
            'password' => 'nullable|string|min:8',
            'nip' => 'nullable|integer',
            'jenis_kelamin' => 'nullable|string', 
            'tanggal_lahir' => 'nullable|date',         
            'no_hp' => 'nullable|string|min:11|max:12',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',

            // 'nama' => 'nullable|string|unique:user,nama',
            // 'username' => 'nullable|string|unique:user,username',
            // 'password' => 'nullable|string|min:8',
            // 'nip' => 'nullable|integer',
            // 'jenis_kelamin' => 'nullable|string', 
            // 'tanggal_lahir' => 'nullable|date',         
            // 'no_hp' => 'nullable|string|min:11|max:12',
            // 'alamat' => 'nullable|string',
            // 'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $user = Auth::user();
        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
            'nip' => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);
        Alert::toast('Berhasil mengubah profil pengguna', 'success');
        return redirect()->route('profile.logout-notice');
    }

    public function logoutNotice(){
        return view('profile.logout-notice');
    }
}
