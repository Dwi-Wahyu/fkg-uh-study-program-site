<?php

namespace App\Controllers\Admin; // Perhatikan bahwa namespace ini seharusnya hanya satu

use App\Controllers\BaseController;
use App\Models\MediaModel;

class MediaBerita extends BaseController
{
    protected $mediaModel;

    public function __construct()
    {
        $this->mediaModel = new MediaModel();
    }

    public function index()
    {
        // Ambil pesan flash data untuk ditampilkan di view (jika ada)
        $data = [
            'title'   => 'Media Berita',
            'media'   => $this->mediaModel->findAll(), // Ambil semua data media
            'errors'  => session()->getFlashdata('errors'),
            'success' => session()->getFlashdata('success'),
        ];
        return view('admin/media-berita/index', $data);
    }

    public function create()
    {
        $data = [
            'title'   => 'Tambah Media Berita',
            'errors'  => session()->getFlashdata('errors'),
            'success' => session()->getFlashdata('success'),
        ];
        return view('admin/media-berita/create', $data);
    }

    public function store()
    {
        $rules = [
            'media_file' => [
                'rules' => 'uploaded[media_file]|max_size[media_file,2048]|mime_in[media_file,image/jpg,image/jpeg,image/png,image/gif,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                'errors' => [
                    'uploaded' => 'Anda harus memilih file untuk diunggah.',
                    'max_size' => 'Ukuran file terlalu besar (maksimal 2MB).',
                    'mime_in'  => 'Tipe file tidak diizinkan. Hanya JPG, JPEG, PNG, GIF, PDF, DOC, DOCX yang diizinkan.'
                ]
            ],
            'alt_text' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required'   => 'Teks alternatif harus diisi.',
                    'max_length' => 'Teks alternatif terlalu panjang (maksimal 255 karakter).'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file    = $this->request->getFile('media_file');
        $altText = $this->request->getPost('alt_text');

        if (!$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->withInput()->with('errors', ['media_file' => 'Terjadi kesalahan saat memproses file. File tidak valid atau sudah dipindahkan.']);
        }

        $newName    = $file->getRandomName(); // Dapatkan nama unik
        $uploadPath = ROOTPATH . 'public/media'; // Pastikan path ini benar dan folder `public/media` ada serta writable

        $file_type = $file->getMimeType();
        $file_size = $file->getSize();

        // Buat direktori jika belum ada
        if (!is_dir($uploadPath)) {
            if (!mkdir($uploadPath, 0777, true)) {
                return redirect()->back()->withInput()->with('errors', ['media_file' => 'Gagal membuat direktori unggahan.']);
            }
        }

        // Pindahkan file
        if (!$file->move($uploadPath, $newName)) {
            return redirect()->back()->withInput()->with('errors', ['media_file' => 'Gagal mengunggah file.']);
        }

        $dataToSave = [
            'file_name' => $newName,
            'file_type' => $file_size,
            'file_size' => $file_type,
            'alt_text'  => $altText,
        ];


        $this->mediaModel->save($dataToSave);

        return redirect()->to('/admin/media-berita/create')->with('success', 'File berhasil diunggah dan disimpan!');
    }

    public function delete($id = null)
    {
        // 1. Cari data media berdasarkan ID
        $media = $this->mediaModel->find($id);

        if (!$media) {
            return redirect()->to('/admin/media-berita')->with('errors', ['Media tidak ditemukan.']);
        }

        // 2. Hapus file fisik dari server
        $filePath = ROOTPATH . 'public/media/' . $media['file_name'];
        if (file_exists($filePath)) {
            unlink($filePath); // Hapus file
        } else {
            // Opsional: Log jika file tidak ditemukan tapi ada di DB
            log_message('warning', 'File media tidak ditemukan di server: ' . $filePath . ' untuk ID: ' . $id);
        }

        // 3. Hapus data dari database
        $this->mediaModel->delete($id);

        return redirect()->to('/admin/media-berita')->with('success', 'Media berhasil dihapus.');
    }
}
