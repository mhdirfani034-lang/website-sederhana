<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['nim' => '2301001', 'nama' => 'Aditya Pratama', 'jurusan' => 'Teknik Informatika', 'angkatan' => 2023, 'email' => 'aditya@example.test'],
            ['nim' => '2301002', 'nama' => 'Citra Maharani', 'jurusan' => 'Sistem Informasi', 'angkatan' => 2023, 'email' => 'citra@example.test'],
            ['nim' => '2202001', 'nama' => 'Dimas Saputra', 'jurusan' => 'Manajemen', 'angkatan' => 2022, 'email' => 'dimas@example.test'],
            ['nim' => '2401001', 'nama' => 'Nadia Putri', 'jurusan' => 'Teknik Informatika', 'angkatan' => 2024, 'email' => 'nadia@example.test'],
        ] as $mahasiswa) {
            Mahasiswa::updateOrCreate(['nim' => $mahasiswa['nim']], $mahasiswa);
        }
    }
}
