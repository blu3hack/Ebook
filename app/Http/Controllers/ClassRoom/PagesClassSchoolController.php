<?php

namespace App\Http\Controllers\ClassRoom;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PagesClassSchoolController extends Controller
{
    // ambil users data
    private function getUserData()
    {
        $user = Auth::user();
        return [
            'Nama' => $user->Nama,
            'Username' => $user->Username,
            'role' => $user->role,
        ];
    }

    // ambil data ebook untuk masing-masing Kelas
    private function getEbooksByGrade(int $grade)
    {
        return DB::table('ebook')
            ->select('id', 'ebook', 'author', 'kelas', 'cover', 'file_pdf')
            ->where('kelas', $grade)
            ->get();
    }

    // returning ke view untuk tampil setiap kelas
    private function showGrade(int $grade)
    {
        $userData = $this->getUserData();
        $ebooks = $this->getEbooksByGrade($grade);

        return view("Kelas.kelas{$grade}", array_merge($userData, [
            'ebooks' => $ebooks,
        ]));
    }

    // functin get route untuk kelas7
    public function Grade7th()
    {
        return $this->showGrade(7);
    }

    // functin get route untuk kelas7
    public function Grade8th()
    {
        return $this->showGrade(8);
    }

    // functin get route untuk kelas7
    public function Grade9th()
    {
        return $this->showGrade(9);
    }

    // function untuk routing jika kelas tidak ada
    public function showGradeByNumber(int $grade)
    {
        // Validate grade range
        if (!in_array($grade, [7, 8, 9])) {
            abort(404);
        }
        return $this->showGrade($grade);
    }
}