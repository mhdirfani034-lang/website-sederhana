<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_shows_live_database_summary(): void
    {
        Mahasiswa::create([
            'nim' => '2301001',
            'nama' => 'Aditya Pratama',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2023,
            'email' => 'aditya@example.test',
        ]);
        Mahasiswa::create([
            'nim' => '2301002',
            'nama' => 'Citra Maharani',
            'jurusan' => 'Sistem Informasi',
            'angkatan' => 2024,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Angka yang selalu')
            ->assertSee('2', false)
            ->assertSee('Teknik Informatika')
            ->assertSee('Citra Maharani');
    }

    public function test_mahasiswa_can_be_created_updated_and_deleted(): void
    {
        $data = [
            'nim' => '2301001',
            'nama' => 'Aditya Pratama',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => '2023',
            'email' => 'aditya@example.test',
        ];

        $this->post(route('mahasiswa.store'), $data)
            ->assertRedirect(route('mahasiswa.index'))
            ->assertSessionHas('success');

        $mahasiswa = Mahasiswa::where('nim', '2301001')->firstOrFail();
        $this->assertSame('Aditya Pratama', $mahasiswa->nama);

        $this->patch(route('mahasiswa.update', $mahasiswa), [
            ...$data,
            'nama' => 'Aditya Pratama Baru',
            'angkatan' => '2024',
        ])->assertRedirect(route('mahasiswa.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('mahasiswa', [
            'id' => $mahasiswa->id,
            'nama' => 'Aditya Pratama Baru',
            'angkatan' => 2024,
        ]);

        $this->delete(route('mahasiswa.destroy', $mahasiswa))
            ->assertRedirect(route('mahasiswa.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('mahasiswa', ['id' => $mahasiswa->id]);
    }

    public function test_nim_and_email_must_be_unique_and_input_is_validated(): void
    {
        Mahasiswa::create([
            'nim' => '2301001',
            'nama' => 'Aditya Pratama',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2023,
            'email' => 'aditya@example.test',
        ]);

        $this->from(route('mahasiswa.index'))
            ->post(route('mahasiswa.store'), [
                'nim' => '2301001',
                'nama' => '',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 1999,
                'email' => 'aditya@example.test',
            ])
            ->assertRedirect(route('mahasiswa.index'))
            ->assertSessionHasErrors(['nim', 'nama', 'angkatan', 'email']);
    }

    public function test_student_directory_can_be_searched(): void
    {
        Mahasiswa::create([
            'nim' => '2301001',
            'nama' => 'Aditya Pratama',
            'jurusan' => 'Teknik Informatika',
            'angkatan' => 2023,
        ]);
        Mahasiswa::create([
            'nim' => '2301002',
            'nama' => 'Citra Maharani',
            'jurusan' => 'Sistem Informasi',
            'angkatan' => 2024,
        ]);

        $this->get(route('mahasiswa.index', ['q' => 'Citra']))
            ->assertOk()
            ->assertSee('Citra Maharani')
            ->assertDontSee('Aditya Pratama');
    }
}
