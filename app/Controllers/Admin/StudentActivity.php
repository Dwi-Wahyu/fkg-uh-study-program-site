<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StudentActivityModel; // Pastikan model sudah di-import

class StudentActivity extends BaseController
{
    protected $studentActivityModel;

    public function __construct()
    {
        $this->studentActivityModel = new StudentActivityModel();
        helper('text');
        helper('form');
    }

    public function index()
    {
        $data = [
            'title'            => 'Daftar Resident Activity',
            'activities'       => $this->studentActivityModel->findAll(), // Ambil semua data aktivitas
            'errors'           => session()->getFlashdata('errors'),
            'success'          => session()->getFlashdata('success'),
        ];
        return view('admin/resident-activity/index', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah Resident Activity',
            'errors'   => session()->getFlashdata('errors'),
            'success'  => session()->getFlashdata('success'),
        ];
        return view('admin/resident-activity/create', $data);
    }

    public function store()
    {
        // 1. Aturan Validasi
        $rules = [
            'judul'     => [
                'rules'  => 'required|max_length[255]',
                'errors' => [
                    'required'   => 'Judul harus diisi.',
                    'max_length' => 'Judul terlalu panjang (maksimal 255 karakter).'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'permit_empty', // Deskripsi bisa kosong
                'errors' => [
                    // Tidak ada error jika permit_empty
                ]
            ],
            'tanggal'   => [
                'rules'  => 'required|valid_date[Y-m-d]', // Format YYYY-MM-DD
                'errors' => [
                    'required'   => 'Tanggal harus diisi.',
                    'valid_date' => 'Format tanggal tidak valid.'
                ]
            ],
            'gambar'    => [
                'rules'  => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                'errors' => [
                    'uploaded' => 'Anda harus memilih gambar untuk diunggah.',
                    'max_size' => 'Ukuran gambar terlalu besar (maksimal 2MB).',
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
        $judul     = $this->request->getPost('judul');
        $deskripsi = $this->request->getPost('deskripsi');
        $tanggal   = $this->request->getPost('tanggal');
        $gambar    = $this->request->getFile('gambar'); // Objek UploadedFile

        // 4. Proses Unggahan Gambar
        $gambarName = null;
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $gambarName = $gambar->getRandomName(); // Nama unik untuk gambar
            $uploadPath = ROOTPATH . 'public/resident-activity/'; // Lokasi penyimpanan gambar

            // Pastikan direktori ada
            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0777, true)) {
                    return redirect()->back()->withInput()->with('errors', ['gambar' => 'Gagal membuat direktori unggahan gambar.']);
                }
            }

            // Pindahkan gambar
            if (!$gambar->move($uploadPath, $gambarName)) {
                return redirect()->back()->withInput()->with('errors', ['gambar' => 'Gagal mengunggah gambar.']);
            }
        } else {
            // Ini seharusnya tidak terjadi jika validasi uploaded[gambar] sudah benar
            return redirect()->back()->withInput()->with('errors', ['gambar' => 'File gambar tidak valid atau sudah dipindahkan.']);
        }

        // 5. Simpan Data ke Database
        $dataToSave = [
            'judul'     => $judul,
            'deskripsi' => $deskripsi,
            'gambar'    => $gambarName, // Simpan nama file gambar
            'tanggal'   => $tanggal,
        ];

        $this->studentActivityModel->save($dataToSave);

        return redirect()->to('/admin/resident-activity')->with('success', 'Resident Activity berhasil ditambahkan!');
    }

    public function edit($id = null)
    {
        $activity = $this->studentActivityModel->find($id);

        if (!$activity) {
            return redirect()->to('/admin/resident-activity')->with('errors', ['Resident Activity tidak ditemukan.']);
        }

        $data = [
            'title'    => 'Edit Resident Activity',
            'activity' => $activity,
            'errors'   => session()->getFlashdata('errors'),
            'success'  => session()->getFlashdata('success'),
        ];
        return view('admin/resident-activity/edit', $data);
    }

    public function update($id = null)
    {
        $activity = $this->studentActivityModel->find($id);

        if (!$activity) {
            return redirect()->to('/admin/resident-activity')->with('errors', ['Resident Activity tidak ditemukan.']);
        }

        // Aturan Validasi untuk Update (gambar tidak harus diupload ulang)
        $rules = [
            'judul'     => [
                'rules'  => 'required|max_length[255]',
                'errors' => [
                    'required'   => 'Judul harus diisi.',
                    'max_length' => 'Judul terlalu panjang (maksimal 255 karakter).'
                ]
            ],
            'deskripsi' => 'permit_empty',
            'tanggal'   => [
                'rules'  => 'required|valid_date[Y-m-d]',
                'errors' => [
                    'required'   => 'Tanggal harus diisi.',
                    'valid_date' => 'Format tanggal tidak valid.'
                ]
            ],
            'gambar'    => [
                // Jika gambar baru diupload, validasi seperti biasa
                // Jika tidak, biarkan kosong (permit_empty) atau abaikan validasi
                'rules'  => 'if_exist|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar (maksimal 2MB).',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Tipe gambar tidak diizinkan. Hanya JPG, JPEG, PNG, GIF, WEBP yang diizinkan.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataToUpdate = [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'tanggal'   => $this->request->getPost('tanggal'),
        ];

        $gambar = $this->request->getFile('gambar');

        // Jika ada gambar baru diupload
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            // Hapus gambar lama jika ada
            $oldGambarPath = ROOTPATH . 'public/resident-activity/' . $activity['gambar'];
            if (file_exists($oldGambarPath)) {
                unlink($oldGambarPath);
            }

            // Unggah gambar baru
            $newGambarName = $gambar->getRandomName();
            $uploadPath    = ROOTPATH . 'public/resident-activity/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            if (!$gambar->move($uploadPath, $newGambarName)) {
                return redirect()->back()->withInput()->with('errors', ['gambar' => 'Gagal mengunggah gambar baru.']);
            }
            $dataToUpdate['gambar'] = $newGambarName; // Update nama gambar di database
        }

        $this->studentActivityModel->update($id, $dataToUpdate);

        return redirect()->to('/admin/resident-activity')->with('success', 'Resident Activity berhasil diperbarui!');
    }

    public function delete($id = null)
    {
        $activity = $this->studentActivityModel->find($id);

        if (!$activity) {
            return redirect()->to('/admin/resident-activity')->with('errors', ['Resident Activity tidak ditemukan.']);
        }

        // Hapus file gambar fisik dari server
        $gambarPath = ROOTPATH . 'public/resident-activity/' . $activity['gambar'];
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        } else {
            log_message('warning', 'Gambar Resident Activity tidak ditemukan di server: ' . $gambarPath . ' untuk ID: ' . $id);
        }

        // Hapus data dari database (akan menggunakan soft delete jika dikonfigurasi di model)
        $this->studentActivityModel->delete($id);

        return redirect()->to('/admin/resident-activity')->with('success', 'Resident Activity berhasil dihapus.');
    }
}
