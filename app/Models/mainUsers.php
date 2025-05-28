<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mainUsers extends Model
{
    protected $fillable = ['Username', 'Token', 'Kelas', 'Nama', 'role'];
}
