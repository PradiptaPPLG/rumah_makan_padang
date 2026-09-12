# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Setup awal Laravel Boost dan panduan AI Agent (`.agents/`, `boost.json`, `AGENTS.md`).
- Instalasi dependensi npm dan build Vite.
- Pengaturan environment database awal.
- Kategori etalase menu: Semua Hidangan, Ayam, Ikan, Daging Sapi, Toping & Bumbu, Minuman Tradisional.
- Perlindungan aset gambar dari klik kanan dan drag (anti-pencurian aset).
- Gambar logo kustom (`Logo_Final.png`) menggantikan logo teks lama di Header, Footer, dan Dashboard Admin.

### Changed
- Nama merek/restoran secara menyeluruh (teks, kode, seeder database, dan nama file gambar) diubah dari "Raso Minang" menjadi "Raso Mandeh".
- Logika filter etalase menu agar item dengan kategori 'Toping & Bumbu' tidak muncul pada tab 'Semua Hidangan'.
- Menghapus gambar besar signature dish dan memindahkan aset `main-foto.webp` ke bagian hero.
- Mengganti dan mengubah nama gambar bagian Cerita Kami menjadi `dapur-raso-mandeh.webp`.
- Update penyesuaian harga seluruh hidangan secara akurat berdasarkan permintaan.
- Penyesuaian besar ukuran logo kustom di semua layout (Header: `h-20`/`h-24`, Footer: `h-20`, Admin: `h-12`).
