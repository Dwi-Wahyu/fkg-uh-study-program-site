<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SurveiModel; // Ubah import model

class Survei extends BaseController // Ubah nama kelas controller
{
    protected $surveiModel; // Ubah nama properti model

    public function __construct()
    {
        $this->surveiModel = new SurveiModel(); // Inisialisasi model baru
        helper(['form', 'url', 'text']);
    }

    /**
     * Menampilkan daftar semua Survei.
     */
    public function index()
    {
        $data = [
            'title'   => 'Daftar Survei', // Sesuaikan judul
            'surveis' => $this->surveiModel->findAll(), // Ambil semua data survei
            'errors'  => session()->getFlashdata('errors'),
            'success' => session()->getFlashdata('success'),
        ];
        return view('admin/survei/index', $data); // Ubah path view
    }

    /**
     * Menampilkan form untuk menambah Survei baru.
     */
    public function create()
    {
        $data = [
            'title'   => 'Tambah Survei', // Sesuaikan judul
            'errors'  => session()->getFlashdata('errors'),
            'success' => session()->getFlashdata('success'),
        ];
        return view('admin/survei/create', $data); // Ubah path view
    }

    /**
     * Menyimpan data Survei baru ke database.
     */
    public function store()
    {
        // Aturan Validasi
        $rules = [
            'judul'     => [
                'rules'  => 'required|max_length[255]',
                'errors' => [
                    'required'   => 'Judul survei harus diisi.',
                    'max_length' => 'Judul survei terlalu panjang (maksimal 255 karakter).'
                ]
            ],
            'deskripsi' => 'permit_empty',
            'link'      => [
                'rules'  => 'required|max_length[255]|valid_url',
                'errors' => [
                    'required'   => 'Link survei harus diisi.',
                    'max_length' => 'Link survei terlalu panjang (maksimal 255 karakter).',
                    'valid_url'  => 'Format link survei tidak valid.'
                ]
            ],
        ];

        // Jalankan Validasi
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil Data
        $dataToSave = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'link'      => $this->request->getPost('link'),
        ];

        // Simpan Data ke Database
        if ($this->surveiModel->save($dataToSave)) { // Ubah nama model
            return redirect()->to('/admin/survei')->with('success', 'Survei berhasil ditambahkan!'); // Ubah URL redirect
        } else {
            $errors = $this->surveiModel->errors(); // Ubah nama model
            log_message('error', 'Gagal menyimpan Survei ke database: ' . json_encode($errors));
            return redirect()->back()->withInput()->with('errors', $errors ?: ['Terjadi kesalahan saat menyimpan data.']);
        }
    }

    /**
     * Menampilkan form untuk mengedit Survei yang sudah ada.
     */
    public function edit($id = null)
    {
        $survei = $this->surveiModel->find($id); // Ubah nama model

        if (!$survei) {
            return redirect()->to('/admin/survei')->with('errors', ['Survei tidak ditemukan.']); // Ubah URL redirect dan pesan
        }

        $data = [
            'title'  => 'Edit Survei', // Sesuaikan judul
            'survei' => $survei,
            'errors' => session()->getFlashdata('errors'),
            'success' => session()->getFlashdata('success'),
        ];
        return view('admin/survei/edit', $data); // Ubah path view
    }

    /**
     * Memperbarui data Survei di database.
     */
    public function update($id = null)
    {
        $survei = $this->surveiModel->find($id); // Ubah nama model

        if (!$survei) {
            return redirect()->to('/admin/survei')->with('errors', ['Survei tidak ditemukan.']); // Ubah URL redirect dan pesan
        }

        // Aturan Validasi untuk Update
        $rules = [
            'judul'     => [
                'rules'  => 'required|max_length[255]',
                'errors' => [
                    'required'   => 'Judul survei harus diisi.',
                    'max_length' => 'Judul survei terlalu panjang (maksimal 255 karakter).'
                ]
            ],
            'deskripsi' => 'permit_empty',
            'link'      => [
                'rules'  => 'required|max_length[255]|valid_url',
                'errors' => [
                    'required'   => 'Link survei harus diisi.',
                    'max_length' => 'Link survei terlalu panjang (maksimal 255 karakter).',
                    'valid_url'  => 'Format link survei tidak valid.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataToUpdate = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'link'      => $this->request->getPost('link'),
        ];

        // Coba update data dan periksa hasilnya
        if ($this->surveiModel->update($id, $dataToUpdate)) { // Ubah nama model
            return redirect()->to('/admin/survei')->with('success', 'Survei berhasil diperbarui!'); // Ubah URL redirect
        } else {
            $errors = $this->surveiModel->errors(); // Ubah nama model
            log_message('error', 'Gagal memperbarui Survei ke database: ' . json_encode($errors));
            return redirect()->back()->withInput()->with('errors', $errors ?: ['Terjadi kesalahan saat memperbarui data.']);
        }
    }

    /**
     * Menghapus data Survei dari database.
     */
    public function delete($id = null)
    {
        $survei = $this->surveiModel->find($id); // Ubah nama model

        if (!$survei) {
            return redirect()->to('/admin/survei')->with('errors', ['Survei tidak ditemukan.']); // Ubah URL redirect dan pesan
        }

        // Hapus data dari database (akan menggunakan soft delete jika dikonfigurasi di model)
        if ($this->surveiModel->delete($id)) { // Ubah nama model
            return redirect()->to('/admin/survei')->with('success', 'Survei berhasil dihapus.'); // Ubah URL redirect
        } else {
            $errors = $this->surveiModel->errors(); // Ubah nama model
            log_message('error', 'Gagal menghapus Survei dari database: ' . json_encode($errors));
            return redirect()->to('/admin/survei')->with('errors', $errors ?: ['Terjadi kesalahan saat menghapus data.']);
        }
    }
}
