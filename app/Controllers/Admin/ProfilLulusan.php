<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProfilLulusanModel; // Pastikan model sudah di-import

class ProfilLulusan extends BaseController
{
    protected $profilLulusanModel;

    public function __construct()
    {
        $this->profilLulusanModel = new ProfilLulusanModel();
        helper(['form', 'url', 'text']); // Muat helper yang dibutuhkan
    }

    /**
     * Menampilkan daftar semua Profil Lulusan.
     */
    public function index()
    {
        $data = [
            'title'          => 'Infografis Profil Lulusan',
            'profilLulusan'  => $this->profilLulusanModel->findAll(), // Ambil semua data profil lulusan
            'errors'         => session()->getFlashdata('errors'),
            'success'        => session()->getFlashdata('success'),
        ];
        return view('admin/profil-lulusan/index', $data);
    }

    /**
     * Menampilkan form untuk menambah Profil Lulusan baru.
     */
    public function create()
    {
        $data = [
            'title'    => 'Tambah Infografis',
            'errors'   => session()->getFlashdata('errors'),
            'success'  => session()->getFlashdata('success'),
        ];
        return view('admin/profil-lulusan/create', $data);
    }

    /**
     * Menyimpan data Profil Lulusan baru ke database.
     */
    public function store()
    {
        // Aturan Validasi
        $rules = [
            'gambar' => [
                'rules'  => 'uploaded[gambar]|max_size[gambar,20480]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                'errors' => [
                    'uploaded' => 'Anda harus memilih gambar untuk diunggah.',
                    'max_size' => 'Ukuran gambar terlalu besar (maksimal 20MB).',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Tipe gambar tidak diizinkan. Hanya JPG, JPEG, PNG, GIF, WEBP yang diizinkan.'
                ]
            ],
            'judul'     => [
                'rules'  => 'permit_empty|max_length[255]',
                'errors' => [
                    'max_length' => 'Judul terlalu panjang (maksimal 255 karakter).'
                ]
            ],
            'deskripsi' => 'permit_empty', // Deskripsi bisa kosong
        ];

        // Jalankan Validasi Controller
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil Data dan File
        $judul     = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');
        $gambar    = $this->request->getFile('gambar'); // Objek UploadedFile

        // Proses Unggahan Gambar
        $gambarName = null;
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $gambarName = $gambar->getRandomName(); // Nama unik untuk gambar
            $uploadPath = ROOTPATH . 'public/profil-lulusan/'; // Lokasi penyimpanan gambar

            // Pastikan direktori ada
            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0777, true)) {
                    // Log error dan kembalikan dengan pesan kesalahan
                    log_message('error', 'Gagal membuat direktori unggahan: ' . $uploadPath);
                    return redirect()->back()->withInput()->with('errors', ['gambar' => 'Gagal membuat direktori unggahan gambar.']);
                }
            }

            // Pindahkan gambar
            if (!$gambar->move($uploadPath, $gambarName)) {
                // Log error dan kembalikan dengan pesan kesalahan
                log_message('error', 'Gagal memindahkan gambar: ' . $gambar->getErrorString() . ' (' . $gambar->getError() . ')');
                return redirect()->back()->withInput()->with('errors', ['gambar' => 'Gagal mengunggah gambar.']);
            }
        } else {
            // Ini seharusnya tidak terjadi jika validasi uploaded[gambar] sudah benar
            log_message('error', 'File gambar tidak valid atau sudah dipindahkan sebelum divalidasi.');
            return redirect()->back()->withInput()->with('errors', ['gambar' => 'File gambar tidak valid atau sudah dipindahkan.']);
        }

        // Simpan Data ke Database
        $dataToSave = [
            'judul'     => $judul,
            'deskripsi' => $deskripsi,
            'gambar'    => $gambarName, // Simpan nama file gambar
        ];

        // Coba simpan data dan periksa hasilnya
        if ($this->profilLulusanModel->save($dataToSave)) {
            return redirect()->to('/admin/profil-lulusan')->with('success', 'Profil Lulusan berhasil ditambahkan!');
        } else {
            // Jika save() gagal, ambil error dari model
            $errors = $this->profilLulusanModel->errors();
            log_message('error', 'Gagal menyimpan Profil Lulusan ke database: ' . json_encode($errors));
            return redirect()->back()->withInput()->with('errors', $errors ?: ['Terjadi kesalahan saat menyimpan data.']);
        }
    }

    /**
     * Menghapus data Profil Lulusan dari database.
     */
    public function delete($id = null)
    {
        $profil = $this->profilLulusanModel->find($id);

        if (!$profil) {
            return redirect()->to('/admin/profil-lulusan')->with('errors', ['Profil Lulusan tidak ditemukan.']);
        }

        // Hapus file gambar fisik dari server
        $gambarPath = ROOTPATH . 'public/uploads/profil_lulusan/' . $profil['gambar'];
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        } else {
            log_message('warning', 'Gambar Profil Lulusan tidak ditemukan di server: ' . $gambarPath . ' untuk ID: ' . $id);
        }

        // Hapus data dari database (akan menggunakan soft delete jika dikonfigurasi di model)
        if ($this->profilLulusanModel->delete($id)) {
            return redirect()->to('/admin/profil-lulusan')->with('success', 'Profil Lulusan berhasil dihapus.');
        } else {
            $errors = $this->profilLulusanModel->errors();
            log_message('error', 'Gagal menghapus Profil Lulusan dari database: ' . json_encode($errors));
            return redirect()->to('/admin/profil-lulusan')->with('errors', $errors ?: ['Terjadi kesalahan saat menghapus data.']);
        }
    }
}
