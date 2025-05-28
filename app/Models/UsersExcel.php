<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersExcel extends Model
{
    //
    protected $fillable = ['Username', 'Token', 'Kelas', 'Nama', 'role'];
}
