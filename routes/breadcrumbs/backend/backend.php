<?php

Breadcrumbs::for('admin.dashboard', function ($trail) {
    $trail->push(__('strings.backend.dashboard.title'), route('admin.dashboard'));
});

require __DIR__.'/auth.php';
require __DIR__.'/log-viewer.php';

//Siswa
Breadcrumbs::for('admin.siswa.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Siswa', route('admin.siswa.index'));
});

Breadcrumbs::for('admin.siswa.create', function ($trail) {
    $trail->parent('admin.siswa.index');
    $trail->push('Tambah', route('admin.siswa.create'));
});

Breadcrumbs::for('admin.siswa.show', function ($trail, $id) {
    $trail->parent('admin.siswa.index');
    $trail->push('Lihat', route('admin.siswa.show', $id));
});

Breadcrumbs::for('admin.siswa.edit', function ($trail, $id) {
    $trail->parent('admin.siswa.index');
    $trail->push('Edit', route('admin.siswa.edit', $id));
});

//Barang
Breadcrumbs::for('admin.barang.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Barang', route('admin.barang.index'));
});

Breadcrumbs::for('admin.barang.create', function ($trail) {
    $trail->parent('admin.barang.index');
    $trail->push('Tambah', route('admin.barang.create'));
});

Breadcrumbs::for('admin.barang.show', function ($trail, $id) {
    $trail->parent('admin.barang.index');
    $trail->push('Lihat', route('admin.barang.show', $id));
});

Breadcrumbs::for('admin.barang.edit', function ($trail, $id) {
    $trail->parent('admin.barang.index');
    $trail->push('Edit', route('admin.barang.edit', $id));
});

//Kasir
Breadcrumbs::for('admin.kasir.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Kasir', route('admin.kasir.index'));
});

Breadcrumbs::for('admin.kasir.barang', function ($trail, $siswa) {
    $trail->parent('admin.kasir.index');
    $trail->push('Tukar Barang', route('admin.kasir.barang', $siswa));
});

Breadcrumbs::for('admin.kasir.point', function ($trail, $siswa) {
    $trail->parent('admin.kasir.index');
    $trail->push('Tukar Point', route('admin.kasir.point', $siswa));
});

Breadcrumbs::for('admin.kasir.konfirmasi', function ($trail, $siswa) {
    $trail->parent('admin.kasir.index');
    $trail->push('Konfirmasi', route('admin.kasir.konfirmasi', $siswa));
});

//Jualan
Breadcrumbs::for('admin.jualan.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Jualan', route('admin.jualan.index'));
});

Breadcrumbs::for('admin.jualan.create', function ($trail) {
    $trail->parent('admin.jualan.index');
    $trail->push('Tambah', route('admin.jualan.create'));
});

Breadcrumbs::for('admin.jualan.show', function ($trail, $id) {
    $trail->parent('admin.jualan.index');
    $trail->push('Lihat', route('admin.jualan.show', $id));
});

Breadcrumbs::for('admin.jualan.edit', function ($trail, $id) {
    $trail->parent('admin.jualan.index');
    $trail->push('Edit', route('admin.jualan.edit', $id));
});

//Transaksi
Breadcrumbs::for('admin.transaksi.index', function ($trail) {
    $trail->parent('admin.dashboard');
    $trail->push('Transaksi', route('admin.transaksi.index'));
});