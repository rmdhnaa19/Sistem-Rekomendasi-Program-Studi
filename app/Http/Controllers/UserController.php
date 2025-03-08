<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Kelola Data User',
            'paragraph' => 'Berikut ini merupakan data user yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola User'],
            ]
        ];
        $activeMenu = 'user';
        $user =  UserModel::all();
        return view('admin.user.index',['breadcrumb' =>$breadcrumb, 'activeMenu' => $activeMenu, 'user' => $user]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select( 'id_user', 'nama', 'username', 'password', 'nip', 'jenis_kelamin','tanggal_lahir', 'no_hp', 'alamat'); 
        return DataTables::of($users)
        ->make(true);
    }

    public function create(){
        $breadcrumb = (object) [
            'title' => 'Tambah Data User',
            'paragraph' => 'Berikut ini merupakan form tambah data user yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola User', 'url' => route('admin.user.index')],
                ['label' => 'Tambah'],
            ]
        ];
        $activeMenu = 'user';
        return view('admin.user.create', [
            'breadcrumb' => $breadcrumb, 
            'activeMenu' => $activeMenu,
        ]);
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string|unique:user,nama',
            'username' => 'required|string|unique:user,username',
            'password' => 'required|string|min:8',
            'nip' => 'required|integer',
            'jenis_kelamin' => 'required|string', 
            'tanggal_lahir' =>  'required|date',         
            'no_hp' => 'nullable|string|min:11|max:12',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Jika ada file foto, simpan file tersebut dan tambahkan path ke validatedData
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_user', $foto, $namaFoto);
            $validatedData['foto'] = $path;
        }
        // Enkripsi password
        $validatedData['password'] = bcrypt($validatedData['password']);

        // Buat user baru
        UserModel::create($validatedData);

        Alert::toast('Data user berhasil ditambah', 'success');

        // Redirect ke halaman User
        return redirect()->route('admin.user.index');
    }


    public function show($id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return response()->json(['error' => 'User tidak ditemukan.'], 404);
        }
        // Render view dengan data tambak
        $view = view('admin.user.show', compact('user'))->render();
        return response()->json(['html' => $view]);
    }


    public function edit(string $id){
        $user = UserModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data User',
            'paragraph' => 'Berikut ini merupakan form edit data user yang terinput ke dalam sistem',
            'list' => [
                ['label' => 'Home', 'url' => route('dashboard.index')],
                ['label' => 'Kelola User', 'url' => route('admin.user.index')],
                ['label' => 'Edit'],
            ]
        ];
        $activeMenu = 'user';

        return view('admin.user.edit', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'user' => $user,]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nama' => 'required|string|unique:user,nama,'.$id.',id_user',
            'username' => 'required|string|unique:user,username,'.$id.',id_user',
            'password' => 'nullable|string|min:8',
            'nip' => 'required|integer',
            'jenis_kelamin' => 'required|string', 
            'tanggal_lahir' =>  'required|date',         
            'no_hp' => 'nullable|string|min:11|max:12',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = UserModel::find($id);

        if ($request->oldImage != '') {
            if ($request->file('foto') == '') {
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
            }else{
                Storage::disk('public')->delete($request->oldImage);
                $foto = $request->file('foto');
                $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('foto_user', $foto, $namaFoto);
                $updateFoto['foto'] = $path;
                
                $user->update([
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                    'nip' => $request->nip,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
                    'foto' => $updateFoto['foto']
                ]);
            }
        } else {
            $foto = $request->file('foto');
            $namaFoto = time() . '.' . $foto->getClientOriginalExtension();
            $path = Storage::disk('public')->putFileAs('foto_user', $foto, $namaFoto);
            $updateFoto['foto'] = $path;
                
            $user->update([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                'nip' => $request->nip,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'foto' => $updateFoto['foto']
            ]);
        }
        Alert::toast('Data user berhasil diubah', 'success');
        return redirect()->route('admin.user.index');
    }

    public function destroy($id)
    {
        $user = UserModel::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Data user tidak ditemukan.'
            ], 404);
        }
    
        try {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Data user berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data user dikarenakan data masih tersambung ke data lain.'
            ], 500);
        }
    }
}