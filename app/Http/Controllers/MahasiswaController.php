<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('q')->toString());

        $mahasiswa = Mahasiswa::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nim', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('jurusan', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('mahasiswa.index', [
            'mahasiswa' => $mahasiswa,
            'totalMahasiswa' => Mahasiswa::count(),
            'totalJurusan' => Mahasiswa::query()->distinct()->count('jurusan'),
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Mahasiswa::create($this->validatedData($request));

        return to_route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->update($this->validatedData($request, $mahasiswa));

        return to_route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->delete();

        return to_route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    /**
     * @return array{nim: string, nama: string, jurusan: string, angkatan: int, email: ?string}
     */
    private function validatedData(Request $request, ?Mahasiswa $mahasiswa = null): array
    {
        $uniqueNim = Rule::unique('mahasiswa', 'nim');
        $uniqueEmail = Rule::unique('mahasiswa', 'email');

        if ($mahasiswa !== null) {
            $uniqueNim->ignore($mahasiswa);
            $uniqueEmail->ignore($mahasiswa);
        }

        return $request->validate([
            'nim' => ['required', 'string', 'max:20', $uniqueNim],
            'nama' => ['required', 'string', 'max:100'],
            'jurusan' => ['required', 'string', 'max:100'],
            'angkatan' => ['required', 'integer', 'between:2000,2100'],
            'email' => ['nullable', 'email', 'max:255', $uniqueEmail],
        ], [
            'nim.required' => 'NIM wajib diisi.',
            'nim.max' => 'NIM tidak boleh lebih dari 20 karakter.',
            'nim.unique' => 'NIM tersebut sudah terdaftar.',
            'nama.required' => 'Nama mahasiswa wajib diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 100 karakter.',
            'jurusan.required' => 'Program studi wajib diisi.',
            'jurusan.max' => 'Program studi tidak boleh lebih dari 100 karakter.',
            'angkatan.required' => 'Tahun angkatan wajib diisi.',
            'angkatan.integer' => 'Tahun angkatan harus berupa angka.',
            'angkatan.between' => 'Tahun angkatan harus antara 2000 dan 2100.',
            'email.email' => 'Masukkan alamat email yang valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email tersebut sudah terdaftar.',
        ]);
    }
}
