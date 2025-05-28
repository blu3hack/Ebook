<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AddEbookController extends Controller
{
    public function Create() {
         $user = Auth::user();

        // Ambil data user login
        $Nama = $user->Nama;
        $Username = $user->Username;
        $role = $user->role;

        // Ambil semua data users dari database
        $ebooks = DB::table('ebook')->select('id', 'ebook', 'author', 'kelas', 'cover', 'file_pdf')->get();
        return view('Admin.ebook', compact('ebooks'));
    }

    public function Store(Request $request)
    {
       $request->validate([
        'cover' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'file_pdf' => 'required|mimes:pdf|max:5120',
        ]);

        $author = $request->Author;
        $ebook = $request->Ebook;
        $kelas = $request->Kelas;
        $cover = $request->file('cover');
        $file_pdf = $request->file('file_pdf');
        $nameFile = $ebook . '_kelas' . $kelas . '.' . $file_pdf->getClientOriginalExtension();
        $coverName = time().'_'.$cover->getClientOriginalName();

        // Simpan file ke folder public/uploads/
        $cover->move(public_path('cover'), $coverName);
        $file_pdf->move(public_path('file'), $nameFile);

        // Simpan nama file ke database
        DB::table('ebook')->insert([
            'ebook' => $ebook,
            'author' => $author,
            'kelas' => $kelas,
            'cover' => $coverName,
            'file_pdf' => $nameFile,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('success', 'File berhasil diupload!');
    }

    public function deleteUsers($id)
    {
        DB::table('ebook')->where('id', $id)->delete();
        return redirect()->route('add-ebook')->with('success', 'Data Berhasil dihapus!');
    }
}
