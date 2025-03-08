<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index(){
        if (auth()->check()) {
            return redirect()->route('dashboard.index');
        }
        return response()
            ->view('login.index')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }

    // public function authenticate(Request $request){
    //     $credentials = $request->validate([
    //         'username' => 'required|string',
    //         'password' => 'required'
    //     ]);
    //     $remember = $request->has('remember');

    //     if (Auth::attempt($credentials, $remember)) {
    //         $request->session()->regenerate();
    //         Alert::toast('Selamat Datang', 'success');
    //         return redirect()->intended('/dashboard');
    //     }
    //     Alert::toast('Username atau Password Salah', 'error');
    //     return back();
    // }

    public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required'
    ]);

    $user = UserModel::where('username', $credentials['username'])->first();

    if ($user) {
        // Cek apakah password sudah terenkripsi, jika belum maka enkripsi
        if (!password_verify($credentials['password'], $user->password)) {
            // Cek jika password belum terenkripsi, maka enkripsi password
            $hashedPassword = bcrypt($credentials['password']);

            // Update password yang belum terenkripsi menjadi terenkripsi
            $user->update(['password' => $hashedPassword]);
        }
    }

    $remember = $request->has('remember');

    if (Auth::attempt($credentials, $remember)) {
        $request->session()->regenerate();
        Alert::toast('Selamat Datang', 'success');
        return redirect()->intended('/dashboard');
    }

    Alert::toast('Username atau Password Salah', 'error');
    return back();
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::toast('Berhasil Log Out', 'success');
        return redirect('/');
    }
}
