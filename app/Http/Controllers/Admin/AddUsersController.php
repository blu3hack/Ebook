<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AddUsersController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        // Ambil data user login
        $Nama = $user->Nama;
        $Username = $user->Username;
        $role = $user->role;

        // Ambil semua data users dari database
        $users = DB::table('users')->select('id', 'Username', 'Nama', 'Kelas', 'role')->get();
        return view('Admin.users', compact('users', 'Nama', 'Username', 'role'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'Username' => 'required|unique:users,Username',
            'Password' => 'required',
        ]);

        $Kelas = $request->Kelas;
        $Sub_Kelas = $request->Sub_kelas;
        $kelasGabungan = $Kelas . '' . $Sub_Kelas;

        DB::table('users')->insert([
            'Username'  => $request->Username,
            'Password'   => Hash::make($request->Password),
            'Kelas' => $kelasGabungan,
            'Nama' => $request->Nama,
            'role' => $request->role,
            'updated_at' => now(),
            'created_at' => now(),
        ]);
        return redirect()->route('add-users')->with('success', 'Data berhasil disimpan!');
    }

    public function deleteUsers($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect()->route('add-users')->with('success', 'Data Berhasil dihapus!');
    }
}
