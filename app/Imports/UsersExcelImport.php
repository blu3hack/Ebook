<?php

namespace App\Imports;

use App\Models\mainUsers;
use App\Models\UsersExcel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;


class UsersExcelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new mainUsers([
            'Username'   => $row[0], // kolom A di Excel
            'Token'  => Hash::make($row[1]), // kolom B
            'Kelas'  => $row[2], // kolom C
            'Nama'  => $row[3], // kolom C
            'role'  => $row[4], // kolom C
        ]);
    }
}
