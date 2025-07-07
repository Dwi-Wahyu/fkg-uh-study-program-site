<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class BeritaController extends BaseController
{
    public function index()
    {
        return view('admin/berita/index', ['title' => 'Daftar Berita']);
    }

    public function create()
    {
        return view('admin/berita/create', ['title' => 'Tambah Berita']);
    }

    public function store()
    {
        // Validasi dan simpan
    }

    public function edit($id)
    {
        return view('admin/berita/edit', ['title' => 'Edit Berita']);
    }

    public function update($id)
    {
        // Update data
    }

    public function delete($id)
    {
        // Hapus data
    }
}
