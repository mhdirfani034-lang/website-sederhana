@extends('layouts.app')

@section('title', 'Data mahasiswa')

@section('content')
    <section class="page-shell management-page">
        <div class="page-heading">
            <div>
                <div class="eyebrow"><span class="eyebrow-dot"></span> PORTAL DATA AKADEMIK</div>
                <h1>Data <span>mahasiswa.</span></h1>
                <p>Kelola informasi mahasiswa dengan mudah dalam satu tempat.</p>
            </div>
            <button class="button button-primary" type="button" data-open-modal>
                <span class="plus-icon" aria-hidden="true">＋</span> Tambah mahasiswa
            </button>
        </div>

        <div class="management-summary">
            <div class="summary-card">
                <span class="summary-symbol icon-lime" aria-hidden="true">♧</span>
                <span><small>Total mahasiswa</small><strong>{{ number_format($totalMahasiswa) }}</strong></span>
            </div>
            <div class="summary-card">
                <span class="summary-symbol icon-lilac" aria-hidden="true">⌘</span>
                <span><small>Program studi</small><strong>{{ number_format($totalJurusan) }}</strong></span>
            </div>
            <div class="summary-tip">
                <span class="tip-icon" aria-hidden="true">✳</span>
                <span><strong>Data terjaga, kerja lebih lega.</strong><small>Semua perubahan tersimpan langsung ke database.</small></span>
            </div>
        </div>

        <section class="table-card" aria-labelledby="table-title">
            <div class="table-toolbar">
                <div>
                    <span class="section-label">DIREKTORI AKADEMIK</span>
                    <h2 id="table-title">Daftar mahasiswa <span class="count-pill">{{ $mahasiswa->total() }}</span></h2>
                </div>
                <form class="search-form" method="GET" action="{{ route('mahasiswa.index') }}" role="search">
                    <label class="sr-only" for="search-mahasiswa">Cari nama, NIM, atau jurusan</label>
                    <span class="search-icon" aria-hidden="true">⌕</span>
                    <input id="search-mahasiswa" type="search" name="q" value="{{ $search }}" placeholder="Cari mahasiswa..." maxlength="100">
                    @if ($search !== '')
                        <a class="clear-search" href="{{ route('mahasiswa.index') }}" aria-label="Hapus pencarian">×</a>
                    @endif
                </form>
            </div>

            @if ($mahasiswa->isNotEmpty())
                <div class="table-scroll">
                    <table class="student-table">
                        <thead>
                            <tr>
                                <th scope="col">MAHASISWA</th>
                                <th scope="col">NIM</th>
                                <th scope="col">PROGRAM STUDI</th>
                                <th scope="col">ANGKATAN</th>
                                <th scope="col">EMAIL</th>
                                <th scope="col"><span class="sr-only">Aksi</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mahasiswa as $item)
                                <tr>
                                    <td data-label="Mahasiswa">
                                        <div class="table-person">
                                            <span class="avatar avatar-{{ $loop->index % 4 }}">{{ strtoupper(mb_substr($item->nama, 0, 1)) }}</span>
                                            <span><strong>{{ $item->nama }}</strong><small>{{ $item->email ?: 'Email belum ditambahkan' }}</small></span>
                                        </div>
                                    </td>
                                    <td data-label="NIM"><span class="nim-value">{{ $item->nim }}</span></td>
                                    <td data-label="Program studi"><span class="major-badge">{{ $item->jurusan }}</span></td>
                                    <td data-label="Angkatan">{{ $item->angkatan }}</td>
                                    <td data-label="Email">{{ $item->email ?: '—' }}</td>
                                    <td class="row-actions">
                                        <button
                                            class="icon-button edit-button"
                                            type="button"
                                            title="Edit {{ $item->nama }}"
                                            aria-label="Edit {{ $item->nama }}"
                                            data-open-modal
                                            data-id="{{ $item->id }}"
                                            data-nim="{{ $item->nim }}"
                                            data-nama="{{ $item->nama }}"
                                            data-jurusan="{{ $item->jurusan }}"
                                            data-angkatan="{{ $item->angkatan }}"
                                            data-email="{{ $item->email }}"
                                            data-update-url="{{ route('mahasiswa.update', $item) }}"
                                        >✎</button>
                                        <form action="{{ route('mahasiswa.destroy', $item) }}" method="POST" data-confirm-delete="Hapus data {{ $item->nama }}? Tindakan ini tidak dapat dibatalkan.">
                                            @csrf
                                            @method('DELETE')
                                            <button class="icon-button delete-button" type="submit" title="Hapus {{ $item->nama }}" aria-label="Hapus {{ $item->nama }}">⌫</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="table-footer">
                    <span>Menampilkan {{ $mahasiswa->firstItem() }}–{{ $mahasiswa->lastItem() }} dari {{ $mahasiswa->total() }} data</span>
                    {{ $mahasiswa->onEachSide(1)->links('vendor.pagination.ruang-kampus') }}
                </div>
            @else
                <div class="table-empty">
                    <span class="empty-icon" aria-hidden="true">✳</span>
                    <h3>{{ $search !== '' ? 'Data tidak ditemukan' : 'Belum ada mahasiswa' }}</h3>
                    <p>{{ $search !== '' ? 'Coba kata kunci lain atau hapus pencarian.' : 'Mulai dengan menambahkan data mahasiswa pertama.' }}</p>
                    @if ($search !== '')
                        <a class="button button-soft" href="{{ route('mahasiswa.index') }}">Hapus pencarian</a>
                    @else
                        <button class="button button-primary" type="button" data-open-modal>Tambah mahasiswa</button>
                    @endif
                </div>
            @endif
        </section>

        <a class="back-link" href="{{ route('home') }}"><span aria-hidden="true">←</span> Kembali ke beranda</a>
    </section>

    @php($editingId = old('_edit_id'))
    <div class="modal-backdrop" id="mahasiswa-modal" aria-hidden="true" hidden>
        <section class="form-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <div class="modal-heading">
                <div>
                    <span class="section-label">FORMULIR DATA</span>
                    <h2 id="modal-title">{{ $editingId ? 'Edit mahasiswa' : 'Tambah mahasiswa' }}</h2>
                </div>
                <button class="modal-close" type="button" data-close-modal aria-label="Tutup formulir">×</button>
            </div>
            <p class="modal-description">Lengkapi informasi di bawah ini. Kolom bertanda <span>*</span> wajib diisi.</p>

            @if ($errors->any())
                <div class="validation-summary" role="alert">
                    <strong>Periksa kembali data yang dimasukkan.</strong>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form
                id="mahasiswa-form"
                action="{{ $editingId ? route('mahasiswa.update', $editingId) : route('mahasiswa.store') }}"
                method="POST"
                data-store-url="{{ route('mahasiswa.store') }}"
            >
                @csrf
                <input type="hidden" name="_method" value="PATCH" @disabled(!$editingId)>
                <input type="hidden" name="_edit_id" value="{{ $editingId }}" @disabled(!$editingId)>
                <div class="form-grid">
                    <div class="form-field">
                        <label for="nim">NIM <span>*</span></label>
                        <input id="nim" name="nim" value="{{ old('nim') }}" maxlength="20" placeholder="Contoh: 2301001" required>
                        @error('nim')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-field">
                        <label for="nama">Nama lengkap <span>*</span></label>
                        <input id="nama" name="nama" value="{{ old('nama') }}" maxlength="100" placeholder="Nama sesuai identitas" required>
                        @error('nama')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-field">
                        <label for="jurusan">Program studi <span>*</span></label>
                        <input id="jurusan" name="jurusan" value="{{ old('jurusan') }}" maxlength="100" placeholder="Contoh: Teknik Informatika" required>
                        @error('jurusan')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-field">
                        <label for="angkatan">Tahun angkatan <span>*</span></label>
                        <input id="angkatan" name="angkatan" type="number" value="{{ old('angkatan') }}" min="2000" max="2100" placeholder="Contoh: 2024" required>
                        @error('angkatan')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-field form-field-wide">
                        <label for="email">Email <span class="optional-label">(opsional)</span></label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" placeholder="nama@email.com">
                        @error('email')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                </div>
                <div class="modal-actions">
                    <button class="button button-soft" type="button" data-close-modal>Batal</button>
                    <button class="button button-primary" type="submit" id="modal-submit">Simpan data</button>
                </div>
            </form>
        </section>
    </div>
@endsection
