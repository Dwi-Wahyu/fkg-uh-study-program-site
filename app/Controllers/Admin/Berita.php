<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel; // Pastikan model sudah di-import

class Berita extends BaseController
{
    protected $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        helper(['form', 'url', 'text']); // Muat helper yang dibutuhkan
    }

    public function index()
    {
        $data = [
            'title'   => 'Daftar Berita',
            'berita'  => $this->beritaModel->findAll(), // Ambil semua data berita
            'errors'  => session()->getFlashdata('errors'),
            'success' => session()->getFlashdata('success'),
        ];
        return view('admin/berita/index', $data); // Anda perlu membuat view ini
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah Berita Baru',
            'errors'   => session()->getFlashdata('errors'),
            'success'  => session()->getFlashdata('success'),
        ];
        return view('admin/berita/create', $data);
    }

    public function store()
    {
        // 1. Aturan Validasi
        $rules = [
            'judul'           => [
                'rules'  => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required'   => 'Judul berita harus diisi.',
                    'min_length' => 'Judul berita minimal 5 karakter.',
                    'max_length' => 'Judul berita maksimal 255 karakter.'
                ]
            ],
            'deskripsi_singkat' => 'permit_empty', // Deskripsi singkat opsional
            'detail'          => 'permit_empty', // Konten detail opsional
            'gambar'          => [ // Thumbnail
                'rules'  => 'permit_empty|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran gambar thumbnail terlalu besar (maksimal 2MB).',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Tipe gambar tidak diizinkan. Hanya JPG, JPEG, PNG, GIF, WEBP yang diizinkan.'
                ]
            ],
        ];

        // 2. Jalankan Validasi
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Ambil Data dan File
        $judul           = $this->request->getPost('judul');
        $deskripsiSingkat = $this->request->getPost('deskripsi_singkat');
        $detailContent   = $this->request->getPost('detail'); // Konten dari TinyMCE
        $gambar          = $this->request->getFile('gambar'); // Objek UploadedFile untuk thumbnail

        // 4. Proses Unggahan Gambar Thumbnail (Opsional)
        $thumbnailName = null;
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $thumbnailName = $gambar->getRandomName(); // Nama unik untuk gambar
            $uploadPath = ROOTPATH . 'public/berita/'; // Lokasi penyimpanan gambar berita

            // Pastikan direktori ada
            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0777, true)) {
                    return redirect()->back()->withInput()->with('errors', ['gambar' => 'Gagal membuat direktori unggahan gambar.']);
                }
            }

            // Pindahkan gambar
            if (!$gambar->move($uploadPath, $thumbnailName)) {
                return redirect()->back()->withInput()->with('errors', ['gambar' => 'Gagal mengunggah gambar.']);
            }
        }

        // 5. Simpan Data ke Database
        $dataToSave = [
            'judul'           => $judul,
            'deskripsi_singkat' => $deskripsiSingkat,
            'detail'          => $detailContent, // Simpan konten TinyMCE
            'thumbnail'       => $thumbnailName, // Simpan nama file thumbnail (bisa null)
        ];

        $this->beritaModel->save($dataToSave);

        return redirect()->to('/admin/berita')->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit($id = null)
    {
        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to('/admin/berita')->with('errors', ['Berita tidak ditemukan.']);
        }

        $data = [
            'title'  => 'Edit Berita',
            'berita' => $berita,
            'errors' => session()->getFlashdata('errors'),
            'success' => session()->getFlashdata('success'),
        ];
        return view('admin/berita/edit', $data); // Anda perlu membuat view ini
    }

    public function update($id = null)
    {
        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to('/admin/berita')->with('errors', ['Berita tidak ditemukan.']);
        }

        // Aturan Validasi untuk Update
        $rules = [
            'judul'           => [
                'rules'  => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required'   => 'Judul berita harus diisi.',
                    'min_length' => 'Judul berita minimal 5 karakter.',
                    'max_length' => 'Judul berita maksimal 255 karakter.'
                ]
            ],
            'deskripsi_singkat' => 'permit_empty',
            'detail'          => 'permit_empty',
            'gambar'          => [ // Thumbnail (opsional untuk update)
                'rules'  => 'if_exist|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran gambar thumbnail terlalu besar (maksimal 2MB).',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Tipe gambar tidak diizinkan. Hanya JPG, JPEG, PNG, GIF, WEBP yang diizinkan.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataToUpdate = [
            'judul'           => $this->request->getPost('judul'),
            'deskripsi_singkat' => $this->request->getPost('deskripsi_singkat'),
            'detail'          => $this->request->getPost('detail'), // Konten TinyMCE
        ];

        $gambar = $this->request->getFile('gambar');
        $uploadPath = ROOTPATH . 'public/berita/';

        // Proses Update Thumbnail
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            // Hapus thumbnail lama jika ada
            if (!empty($berita['thumbnail']) && file_exists($uploadPath . $berita['thumbnail'])) {
                unlink($uploadPath . $berita['thumbnail']);
            }
            $newThumbnailName = $gambar->getRandomName();
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            if ($gambar->move($uploadPath, $newThumbnailName)) {
                $dataToUpdate['thumbnail'] = $newThumbnailName;
            } else {
                return redirect()->back()->withInput()->with('errors', ['gambar' => 'Gagal mengunggah gambar thumbnail baru.']);
            }
        } else if ($this->request->getPost('remove_thumbnail') === '1') { // Opsi untuk menghapus thumbnail tanpa upload baru
            if (!empty($berita['thumbnail']) && file_exists($uploadPath . $berita['thumbnail'])) {
                unlink($uploadPath . $berita['thumbnail']);
            }
            $dataToUpdate['thumbnail'] = null;
        }

        $this->beritaModel->update($id, $dataToUpdate);

        return redirect()->to('/admin/berita')->with('success', 'Berita berhasil diperbarui!');
    }

    public function delete($id = null)
    {
        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to('/admin/berita')->with('errors', ['Berita tidak ditemukan.']);
        }

        $uploadPath = ROOTPATH . 'public/berita/';

        // Hapus file thumbnail fisik dari server jika ada
        if (!empty($berita['thumbnail']) && file_exists($uploadPath . $berita['thumbnail'])) {
            unlink($uploadPath . $berita['thumbnail']);
        } else if (!empty($berita['thumbnail'])) {
            log_message('warning', 'Thumbnail berita tidak ditemukan di server: ' . $uploadPath . $berita['thumbnail'] . ' untuk ID: ' . $id);
        }

        // Hapus data dari database (akan menggunakan soft delete)
        $this->beritaModel->delete($id);

        return redirect()->to('/admin/berita')->with('success', 'Berita berhasil dihapus.');
    }

    public function detail($id = null)
    {
        $berita = $this->beritaModel->find($id);

        if (empty($berita)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Berita dengan ID ' . $id . ' tidak ditemukan.');
        }

        // Ambil 3 berita terbaru lainnya (rekomendasi)
        // Order by created_at DESC, ambil 4, lalu filter berita utama
        $rekomendasiBerita = $this->beritaModel
            ->where('id !=', $id) // Kecualikan berita yang sedang dilihat
            ->orderBy('created_at', 'DESC')
            ->findAll(3); // Ambil 3 berita terbaru

        $data = [
            'title'             => $berita['judul'],
            'berita'            => $berita,
            'rekomendasiBerita' => $rekomendasiBerita, // Teruskan ke view
        ];

        return view('berita/detail', $data);
    }
}
