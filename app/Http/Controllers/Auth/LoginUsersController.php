<?php

namespace App\Http\Controllers\Auth;

use App\Models\LoginUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginUsersController extends Controller
{
public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'Username' => 'required|string',
            'Password' => 'required|string',
        ]);

        $credentials = $request->only('Username', 'Password');

        // Karena Password disimpan hash, kita pakai manual check
        $user = \App\Models\User::where('Username', $credentials['Username'])->first();

        if ($user && Hash::check($credentials['Password'], $user->Password)) {
            Auth::login($user);
            $request->session()->regenerate();
            // Redirect sesuai role
            $role = $user->role;
            if($role == 'Siswa') {
                return redirect()->intended('/kelas7');
            }elseif($role != 'student') {
                return redirect()->intended('/admin');
            }else{
                return redirect()->intended('/login');
            }
        }

        return back()->withErrors([
            'Username' => 'Username atau Password salah',
        ])->onlyInput('Username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
