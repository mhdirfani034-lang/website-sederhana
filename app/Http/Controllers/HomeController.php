<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'totalMahasiswa' => Mahasiswa::count(),
            'totalJurusan' => Mahasiswa::query()->distinct()->count('jurusan'),
            'angkatanTerbaru' => Mahasiswa::max('angkatan'),
            'mahasiswaTerbaru' => Mahasiswa::latest()->take(4)->get(),
        ]);
    }
}
