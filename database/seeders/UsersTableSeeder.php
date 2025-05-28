<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(['Username' => 'Guru','Password' => Hash::make('12345'),'Kelas' => '7A','Nama' => 'Bayu Jaya','Role' => 'Guru',]);
        DB::table('users')->insert(['Username' => 'Siswa','Password' => Hash::make('123456'),'Kelas' => '7A','Nama' => 'Bayu Jaya','Role' => 'Siswa',]);
    }
}
