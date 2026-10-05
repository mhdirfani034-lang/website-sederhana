@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <section class="hero page-shell">
        <div class="hero-copy">
            <div class="eyebrow"><span class="eyebrow-dot"></span> PORTAL DATA AKADEMIK</div>
            <h1>Urus data kampus,<br><span>tanpa bikin rumit.</span></h1>
            <p class="hero-description">Satu ruang sederhana untuk melihat dan mengelola data mahasiswa. Rapi, jelas, dan selalu siap dipakai.</p>
            <div class="hero-actions">
                <a class="button button-primary" href="{{ route('mahasiswa.index') }}">
                    Buka data mahasiswa <span aria-hidden="true">↗</span>
                </a>
                <a class="text-link" href="#tentang">Kenali portal ini <span aria-hidden="true">↓</span></a>
            </div>
            <div class="hero-note">
                <span class="note-icon" aria-hidden="true">✳</span>
                <span>Dibuat untuk pengelolaan akademik yang lebih teratur.</span>
            </div>
        </div>
        <div class="hero-art" aria-label="Ilustrasi pengelolaan data mahasiswa">
            <div class="art-orbit orbit-one"></div>
            <div class="art-orbit orbit-two"></div>
            <div class="art-card art-card-back">
                <div class="mini-card-top"><span></span><span></span><span></span></div>
                <div class="mini-lines"><i></i><i></i><i></i></div>
            </div>
            <div class="art-card art-card-main">
                <div class="art-card-heading">
                    <span class="art-icon" aria-hidden="true">▦</span>
                    <span><strong>Data mahasiswa</strong><small>Ringkasan akademik</small></span>
                    <span class="art-more">···</span>
                </div>
                <div class="art-total"><strong>{{ number_format($totalMahasiswa) }}</strong><span>mahasiswa terdaftar</span></div>
                <div class="art-chart" aria-hidden="true">
                    <i style="--bar: 36%"></i><i style="--bar: 52%"></i><i style="--bar: 43%"></i><i style="--bar: 67%"></i><i style="--bar: 58%"></i><i style="--bar: 82%"></i><i style="--bar: 72%"></i><i style="--bar: 100%"></i>
                </div>
                <div class="art-chart-labels"><span>Jan</span><span>Mar</span><span>Mei</span><span>Jul</span></div>
            </div>
            <div class="art-float">
                <span class="float-check" aria-hidden="true">✓</span>
                <span><strong>Data tersimpan</strong><small>Semua tercatat rapi</small></span>
            </div>
            <div class="art-sparkle sparkle-one" aria-hidden="true">✳</div>
            <div class="art-sparkle sparkle-two" aria-hidden="true">✦</div>
        </div>
    </section>

    <section class="stats-strip page-shell" aria-label="Ringkasan data saat ini">
        <div class="stats-intro">
            <span class="stats-kicker">SEKILAS PORTAL</span>
            <strong>Angka yang selalu<br>terkini dari database.</strong>
        </div>
        <div class="stat-item">
            <span class="stat-icon icon-lime" aria-hidden="true">♧</span>
            <span class="stat-value">{{ number_format($totalMahasiswa) }}</span>
            <span class="stat-label">Mahasiswa terdaftar</span>
        </div>
        <div class="stat-item">
            <span class="stat-icon icon-lilac" aria-hidden="true">⌘</span>
            <span class="stat-value">{{ number_format($totalJurusan) }}</span>
            <span class="stat-label">Program studi</span>
        </div>
        <div class="stat-item">
            <span class="stat-icon icon-peach" aria-hidden="true">◷</span>
            <span class="stat-value">{{ $angkatanTerbaru ?? '—' }}</span>
            <span class="stat-label">Angkatan terbaru</span>
        </div>
    </section>

    <section class="home-lower page-shell" id="tentang">
        <div class="section-copy">
            <div class="eyebrow"><span class="eyebrow-dot"></span> DIBUAT UNTUK KEMUDAHAN</div>
            <h2>Semua data penting,<br><span>dekat dalam satu klik.</span></h2>
            <p>Tambah, cari, perbarui, atau hapus data mahasiswa lewat halaman pengelolaan yang praktis. Perubahan langsung tersimpan ke database.</p>
            <a class="text-link" href="{{ route('mahasiswa.index') }}">Mulai kelola data <span aria-hidden="true">→</span></a>
        </div>
        <div class="recent-card">
            <div class="recent-heading">
                <div><span class="section-label">BARU DITAMBAHKAN</span><h3>Mahasiswa terbaru</h3></div>
                <a href="{{ route('mahasiswa.index') }}" aria-label="Lihat semua data mahasiswa">↗</a>
            </div>
            @forelse ($mahasiswaTerbaru as $item)
                <div class="recent-row">
                    <span class="avatar avatar-{{ $loop->index % 4 }}">{{ strtoupper(mb_substr($item->nama, 0, 1)) }}</span>
                    <span class="recent-person"><strong>{{ $item->nama }}</strong><small>{{ $item->jurusan }}</small></span>
                    <span class="recent-year">{{ $item->angkatan }}</span>
                </div>
            @empty
                <div class="empty-recent">
                    <span class="empty-icon" aria-hidden="true">✳</span>
                    <strong>Belum ada data mahasiswa</strong>
                    <span>Data yang ditambahkan akan tampil di sini.</span>
                    <a class="text-link" href="{{ route('mahasiswa.index') }}">Tambahkan mahasiswa <span aria-hidden="true">→</span></a>
                </div>
            @endforelse
        </div>
    </section>
@endsection
