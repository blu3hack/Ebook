<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginUsers extends Model
{
    protected $table = 'main_users';

    protected $primaryKey = 'Username';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['Username', 'Token', 'Kelas', 'Nama', 'role'];
    public $timestamps = false;
}
