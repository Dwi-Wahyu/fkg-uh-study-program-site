<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KurikulumModel;

class Kurikulum extends BaseController
{
    protected $kurikulumModel;

    public function __construct()
    {
        $this->kurikulumModel = new KurikulumModel();
        helper(['form', 'url', 'filesystem', 'text']); // Memuat helper yang diperlukan
    }

    public function index()
    {
        $data = [
            'title'     => 'Daftar Kurikulum',
            'kurikulum' => $this->kurikulumModel->findAll(), // Mengambil semua data kurikulum
        ];

        return view('admin/kurikulum/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kurikulum Baru',
            'validation' => \Config\Services::validation(),
        ];

        return view('admin/kurikulum/create', $data);
    }

    public function store()
    {
        // Aturan validasi untuk input form
        $rules = [
            'gambar' => [
                'rules' => 'uploaded[gambar]|max_size[gambar,20480]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                'errors' => [
                    'uploaded' => 'Anda harus memilih gambar untuk kurikulum.',
                    'max_size' => 'Ukuran gambar terlalu besar (maksimal 20MB).',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Tipe gambar tidak diizinkan. Hanya JPG, JPEG, PNG, GIF, WEBP yang diizinkan.'
                ]
            ],
            'keterangan' => [
                'rules' => 'permit_empty', // Keterangan opsional
            ],
            'keterangan_en' => [
                'rules' => 'permit_empty', // Keterangan bahasa Inggris opsional
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $gambarName = $gambar->getRandomName(); // Nama unik untuk gambar

        $uploadPath = ROOTPATH . 'public/kurikulum';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true); // Buat folder jika belum ada
        }
        $gambar->move($uploadPath, $gambarName);

        // Siapkan data untuk disimpan ke database
        $dataToSave = [
            'gambar'        => $gambarName,
            'keterangan'    => $this->request->getPost('keterangan'),
            'keterangan_en' => $this->request->getPost('keterangan_en'),
        ];

        // Simpan data ke database
        if ($this->kurikulumModel->save($dataToSave)) {
            session()->setFlashdata('success', 'Kurikulum berhasil ditambahkan.');
            return redirect()->to(base_url('/admin/kurikulum'));
        } else {
            // Jika gagal menyimpan ke DB, hapus gambar yang sudah diunggah
            unlink($uploadPath . '/' . $gambarName);
            session()->setFlashdata('error', 'Gagal menambahkan kurikulum. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function delete($id = null)
    {
        if ($id === null) {
            session()->setFlashdata('error', 'ID Kurikulum tidak ditemukan.');
            return redirect()->to(base_url('admin/kurikulum'));
        }

        // Ambil data kurikulum untuk mendapatkan nama file gambar
        $kurikulum = $this->kurikulumModel->find($id);

        if (!$kurikulum) {
            session()->setFlashdata('error', 'Kurikulum tidak ditemukan.');
            return redirect()->to(base_url('/admin/kurikulum'));
        }

        // Lakukan soft delete
        if ($this->kurikulumModel->delete($id)) {
            // Hapus juga file gambar dari folder public/kurikulum
            $filePath = ROOTPATH . 'public/kurikulum/' . $kurikulum['gambar'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            session()->setFlashdata('success', 'Kurikulum berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus kurikulum. Silakan coba lagi.');
        }

        return redirect()->to(base_url('/admin/kurikulum'));
    }
}
