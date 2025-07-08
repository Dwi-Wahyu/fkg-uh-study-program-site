<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SaranaPrasaranaModel; // Pastikan model sudah di-import

class SaranaPrasarana extends BaseController
{
    protected $saranaPrasaranaModel;

    public function __construct()
    {
        $this->saranaPrasaranaModel = new SaranaPrasaranaModel();
        helper(['form', 'url', 'text']); // Muat helper yang dibutuhkan
    }

    public function index()
    {
        $data = [
            'title'              => 'Daftar Sarana dan Prasarana',
            'sarpras'            => $this->saranaPrasaranaModel->findAll(), // Ambil semua data
            'errors'             => session()->getFlashdata('errors'),
            'success'            => session()->getFlashdata('success'),
        ];
        return view('admin/sarana-prasarana/index', $data);
    }

    public function create()
    {
        $data = [
            'title'    => 'Tambah Sarana dan Prasarana',
            'errors'   => session()->getFlashdata('errors'),
            'success'  => session()->getFlashdata('success'),
        ];
        return view('admin/sarana-prasarana/create', $data);
    }

    public function store()
    {
        // 1. Aturan Validasi
        $rules = [
            'nama'             => [
                'rules'  => 'required|max_length[255]',
                'errors' => [
                    'required'   => 'Nama sarana/prasarana harus diisi.',
                    'max_length' => 'Nama terlalu panjang (maksimal 255 karakter).'
                ]
            ],
            'deskripsi'        => 'permit_empty', // Deskripsi opsional
            'gambar_thumbnail' => [
                'rules'  => 'uploaded[gambar_thumbnail]|max_size[gambar_thumbnail,20480]|is_image[gambar_thumbnail]|mime_in[gambar_thumbnail,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                'errors' => [
                    'uploaded' => 'Anda harus memilih gambar thumbnail.',
                    'max_size' => 'Ukuran gambar thumbnail terlalu besar (maksimal 20MB).',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Tipe gambar tidak diizinkan. Hanya JPG, JPEG, PNG, GIF, WEBP yang diizinkan.'
                ]
            ],
            'file_video'       => [
                'rules'  => 'permit_empty|max_size[file_video,102400]|mime_in[file_video,video/mp4,video/webm,video/ogg]', // Max 20MB untuk video
                'errors' => [
                    'max_size' => 'Ukuran file video terlalu besar (maksimal 100MB).',
                    'mime_in'  => 'Tipe video tidak diizinkan. Hanya MP4, WebM, Ogg yang diizinkan.'
                ]
            ],
        ];

        // 2. Jalankan Validasi
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Ambil Data dan File
        $nama        = $this->request->getPost('nama');
        $deskripsi   = $this->request->getPost('deskripsi');
        $gambarThumbnail = $this->request->getFile('gambar_thumbnail');
        $fileVideo   = $this->request->getFile('file_video');

        // 4. Proses Unggahan Gambar Thumbnail (Wajib)
        $thumbnailName = null;
        if ($gambarThumbnail && $gambarThumbnail->isValid() && !$gambarThumbnail->hasMoved()) {
            $thumbnailName = $gambarThumbnail->getRandomName();
            $uploadPath = ROOTPATH . 'public/sarana-prasarana/';

            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0777, true)) {
                    return redirect()->back()->withInput()->with('errors', ['gambar_thumbnail' => 'Gagal membuat direktori unggahan thumbnail.']);
                }
            }
            if (!$gambarThumbnail->move($uploadPath, $thumbnailName)) {
                return redirect()->back()->withInput()->with('errors', ['gambar_thumbnail' => 'Gagal mengunggah gambar thumbnail.']);
            }
        } else {
            // Ini akan menangkap kasus jika file tidak valid meski validasi passed (sangat jarang)
            return redirect()->back()->withInput()->with('errors', ['gambar_thumbnail' => 'File thumbnail tidak valid atau sudah dipindahkan.']);
        }

        // 5. Proses Unggahan Video (Opsional)
        $videoName = null;
        if ($fileVideo && $fileVideo->isValid() && !$fileVideo->hasMoved()) {
            $videoName = $fileVideo->getRandomName();
            $uploadPath = ROOTPATH . 'public/sarana-prasarana/'; // Gunakan folder yang sama

            if (!is_dir($uploadPath)) { // Pastikan direktori ada (mungkin sudah dibuat oleh thumbnail)
                if (!mkdir($uploadPath, 0777, true)) {
                    return redirect()->back()->withInput()->with('errors', ['file_video' => 'Gagal membuat direktori unggahan video.']);
                }
            }
            if (!$fileVideo->move($uploadPath, $videoName)) {
                return redirect()->back()->withInput()->with('errors', ['file_video' => 'Gagal mengunggah file video.']);
            }
        }

        // 6. Simpan Data ke Database
        $dataToSave = [
            'nama'             => $nama,
            'deskripsi'        => $deskripsi,
            'gambar_thumbnail' => $thumbnailName,
            'file_video'       => $videoName, // Akan null jika tidak ada video yang diunggah
        ];

        $this->saranaPrasaranaModel->save($dataToSave);

        return redirect()->to('/admin/sarana-prasarana')->with('success', 'Sarana/Prasarana berhasil ditambahkan!');
    }

    public function edit($id = null)
    {
        $sarpras = $this->saranaPrasaranaModel->find($id);

        if (!$sarpras) {
            return redirect()->to('/admin/sarana-prasarana')->with('errors', ['Sarana/Prasarana tidak ditemukan.']);
        }

        $data = [
            'title'    => 'Edit Sarana dan Prasarana',
            'sarpras'  => $sarpras,
            'errors'   => session()->getFlashdata('errors'),
            'success'  => session()->getFlashdata('success'),
        ];
        return view('admin/sarana-prasarana/edit', $data);
    }

    public function update($id = null)
    {
        $sarpras = $this->saranaPrasaranaModel->find($id);

        if (!$sarpras) {
            return redirect()->to('/admin/sarana-prasarana')->with('errors', ['Sarana/Prasarana tidak ditemukan.']);
        }

        // 1. Aturan Validasi untuk Update (gambar/video bisa tidak diupload ulang)
        $rules = [
            'nama'             => [
                'rules'  => 'required|max_length[255]',
                'errors' => [
                    'required'   => 'Nama sarana/prasarana harus diisi.',
                    'max_length' => 'Nama terlalu panjang (maksimal 255 karakter).'
                ]
            ],
            'deskripsi'        => 'permit_empty',
            'gambar_thumbnail' => [ // Jika ada unggahan baru
                'rules'  => 'if_exist|max_size[gambar_thumbnail,2048]|is_image[gambar_thumbnail]|mime_in[gambar_thumbnail,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran gambar thumbnail terlalu besar (maksimal 2MB).',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Tipe gambar tidak diizinkan. Hanya JPG, JPEG, PNG, GIF, WEBP yang diizinkan.'
                ]
            ],
            'file_video'       => [ // Jika ada unggahan baru
                'rules'  => 'if_exist|max_size[file_video,20480]|mime_in[file_video,video/mp4,video/webm,video/ogg]',
                'errors' => [
                    'max_size' => 'Ukuran file video terlalu besar (maksimal 20MB).',
                    'mime_in'  => 'Tipe video tidak diizinkan. Hanya MP4, WebM, Ogg yang diizinkan.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataToUpdate = [
            'nama'      => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
        ];

        $gambarThumbnail = $this->request->getFile('gambar_thumbnail');
        $fileVideo       = $this->request->getFile('file_video');
        $uploadPath      = ROOTPATH . 'public/sarana-prasarana/';

        // Proses Update Gambar Thumbnail
        if ($gambarThumbnail && $gambarThumbnail->isValid() && !$gambarThumbnail->hasMoved()) {
            // Hapus thumbnail lama jika ada dan bukan thumbnail default
            if (!empty($sarpras['gambar_thumbnail']) && file_exists($uploadPath . $sarpras['gambar_thumbnail'])) {
                unlink($uploadPath . $sarpras['gambar_thumbnail']);
            }
            $newThumbnailName = $gambarThumbnail->getRandomName();
            if ($gambarThumbnail->move($uploadPath, $newThumbnailName)) {
                $dataToUpdate['gambar_thumbnail'] = $newThumbnailName;
            } else {
                return redirect()->back()->withInput()->with('errors', ['gambar_thumbnail' => 'Gagal mengunggah gambar thumbnail baru.']);
            }
        }

        // Proses Update Video
        if ($fileVideo && $fileVideo->isValid() && !$fileVideo->hasMoved()) {
            // Hapus video lama jika ada
            if (!empty($sarpras['file_video']) && file_exists($uploadPath . $sarpras['file_video'])) {
                unlink($uploadPath . $sarpras['file_video']);
            }
            $newVideoName = $fileVideo->getRandomName();
            if ($fileVideo->move($uploadPath, $newVideoName)) {
                $dataToUpdate['file_video'] = $newVideoName;
            } else {
                return redirect()->back()->withInput()->with('errors', ['file_video' => 'Gagal mengunggah file video baru.']);
            }
        } else if ($this->request->getPost('remove_video') === '1') { // Cek jika ada permintaan untuk menghapus video
            // Hapus video lama jika ada
            if (!empty($sarpras['file_video']) && file_exists($uploadPath . $sarpras['file_video'])) {
                unlink($uploadPath . $sarpras['file_video']);
            }
            $dataToUpdate['file_video'] = null; // Set video ke null di DB
        }


        $this->saranaPrasaranaModel->update($id, $dataToUpdate);

        return redirect()->to('/admin/sarana-prasarana')->with('success', 'Sarana/Prasarana berhasil diperbarui!');
    }

    public function delete($id = null)
    {
        $sarpras = $this->saranaPrasaranaModel->find($id);

        if (!$sarpras) {
            return redirect()->to('/admin/sarana-prasarana')->with('errors', ['Sarana/Prasarana tidak ditemukan.']);
        }

        $uploadPath = ROOTPATH . 'public/sarana-prasarana/';

        // Hapus file gambar thumbnail fisik dari server
        if (!empty($sarpras['gambar_thumbnail']) && file_exists($uploadPath . $sarpras['gambar_thumbnail'])) {
            unlink($uploadPath . $sarpras['gambar_thumbnail']);
        } else {
            log_message('warning', 'Gambar thumbnail sarana/prasarana tidak ditemukan di server: ' . $uploadPath . $sarpras['gambar_thumbnail'] . ' untuk ID: ' . $id);
        }

        // Hapus file video fisik dari server (jika ada)
        if (!empty($sarpras['file_video']) && file_exists($uploadPath . $sarpras['file_video'])) {
            unlink($uploadPath . $sarpras['file_video']);
        } else if (!empty($sarpras['file_video'])) { // Log jika ada nama file tapi tidak ditemukan
            log_message('warning', 'File video sarana/prasarana tidak ditemukan di server: ' . $uploadPath . $sarpras['file_video'] . ' untuk ID: ' . $id);
        }

        // Hapus data dari database (akan menggunakan soft delete)
        $this->saranaPrasaranaModel->delete($id);

        return redirect()->to('/admin/sarana-prasarana')->with('success', 'Sarana/Prasarana berhasil dihapus.');
    }
}
