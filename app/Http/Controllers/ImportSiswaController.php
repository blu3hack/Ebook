<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportSiswaController extends Controller
{
   public function import()
    {
        // Ambil semua data dari tabel siswa
        $siswa = DB::table('siswa')->get();

        // Siapkan array untuk batch insert
        $insertData = [];

        foreach ($siswa as $row) {
            $insertData[] = [
                'Username' => $row->Username,
                'Token' => Hash::make($row->Token), // Hash token
                'Kelas' => $row->Kelas,
                'Nama' => $row->Nama,
                'role' => 'student', // Tambah kolom role dengan default 'student'
            ];
        }

        // Insert ke tabel tujuan
        if (!empty($insertData)) {
            DB::table('mainUsers')->insert($insertData);
        }

        return response()->json(['status' => 'success', 'message' => 'Data siswa berhasil diimport.']);
    }
}
