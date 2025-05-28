<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function login() {
        return view('Auth.login');
    }

    public function ProsesLogin(Request $request) {
        $credentials = $request->validate([
            'Username' => ['required'],
            'Password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/kelas7');
        }
 
        return back()->withErrors([
            'email' => 'Login Gagal',
        ])->onlyInput('email');
    }

    public function logout() {
        Auth::logout();
        return redirect('login');
    }
}
