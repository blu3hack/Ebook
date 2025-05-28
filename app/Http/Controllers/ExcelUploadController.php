<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UsersExcelImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelUploadController extends Controller
{
    public function form()
    {
        return view('excel.upload'); // nanti kita buat blade-nya
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new UsersExcelImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data berhasil diimpor!');
    }
}
