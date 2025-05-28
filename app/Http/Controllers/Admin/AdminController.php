<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function Admin() {
        $user = Auth::user();
        $Nama = $user->Nama;
        $Username = $user->Username;
        $role = $user->role;
        return view('Admin.admin', [
            'Nama' => $Nama,
            'Username' => $Username,
            'role' => $role,
        ]);
    }

    public function Users() {
        $user = Auth::user();
        $Nama = $user->Nama;
        $Username = $user->Username;
        $role = $user->role;
        return view('Admin.users', [
            'Nama' => $Nama,
            'Username' => $Username,
            'role' => $role,
        ]);
    }

    public function Ebook() {
        $user = Auth::user();
        $Nama = $user->Nama;
        $Username = $user->Username;
        $role = $user->role;
        return view('Admin.ebook', [
            'Nama' => $Nama,
            'Username' => $Username,
            'role' => $role,
        ]);
    }

    public function Panel() {
        $user = Auth::user();
        $Nama = $user->Nama;
        $Username = $user->Username;
        $role = $user->role;
        return view('Admin.panel', [
            'Nama' => $Nama,
            'Username' => $Username,
            'role' => $role,
        ]);
    }
}
