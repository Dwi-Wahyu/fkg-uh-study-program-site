<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KetuaProgramStudiModel;

class KetuaProgramStudi extends BaseController
{
    protected $ketuaProdiModel;

    public function __construct()
    {
        $this->ketuaProdiModel = new KetuaProgramStudiModel();
        helper(['form', 'url']); // Muat helper yang dibutuhkan
    }

    // Metode utama untuk menampilkan/mengedit data (biasanya menggunakan ID 1)
    public function index()
    {
        // Selalu ambil data dengan ID 1 (atau ID yang Anda tentukan sebagai single row)
        $ketuaProdi = $this->ketuaProdiModel->find(1);

        // Jika data belum ada (meskipun migration seed seharusnya sudah membuatnya),
        // bisa diarahkan untuk membuat entri default
        if (!$ketuaProdi) {
            // Ini seharusnya tidak terjadi jika seeding di migration berhasil
            // Anda bisa tambahkan logika insert default di sini juga jika diperlukan
            $dataDefault = [
                'nama'     => 'Default Ketua Prodi',
                'sambutan' => 'Default sambutan.',
                'gambar'   => null,
            ];
            $this->ketuaProdiModel->save($dataDefault);
            $ketuaProdi = $this->ketuaProdiModel->find(1); // Ambil lagi setelah insert
        }

        $data = [
            'title'      => 'Pengaturan Ketua Program Studi',
            'ketuaProdi' => $ketuaProdi,
            'errors'     => session()->getFlashdata('errors'),
            'success'    => session()->getFlashdata('success'),
        ];
        return view('admin/ketua-program-studi/edit', $data); // Langsung ke form edit
    }

    // Metode untuk memproses pembaruan data
    public function update()
    {
        // ID yang akan selalu diperbarui adalah 1
        $id = 1;
        $ketuaProdi = $this->ketuaProdiModel->find($id);

        if (!$ketuaProdi) {
            return redirect()->to('/admin/ketua-program-studi')->with('errors', ['Data Ketua Program Studi tidak ditemukan.']);
        }

        $rules = [
            'nama'     => 'required|max_length[255]',
            'sambutan' => 'permit_empty',
            'gambar'   => [
                'rules' => 'if_exist|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar (maksimal 2MB).',
                    'is_image' => 'File yang diunggah bukan gambar yang valid.',
                    'mime_in'  => 'Tipe gambar tidak diizinkan.'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataToUpdate = [
            'nama'     => $this->request->getPost('nama'),
            'sambutan' => $this->request->getPost('sambutan'),
        ];

        $gambar = $this->request->getFile('gambar');
        $uploadPath = ROOTPATH . 'public/ketua-prodi/'; // Folder untuk gambar ketua prodi

        // Proses unggah gambar baru
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            // Hapus gambar lama jika ada
            if (!empty($ketuaProdi['gambar']) && file_exists($uploadPath . $ketuaProdi['gambar'])) {
                unlink($uploadPath . $ketuaProdi['gambar']);
            }
            $newGambarName = $gambar->getRandomName();
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            if (!$gambar->move($uploadPath, $newGambarName)) {
                return redirect()->back()->withInput()->with('errors', ['gambar' => 'Gagal mengunggah gambar baru.']);
            }
            $dataToUpdate['gambar'] = $newGambarName;
        } else if ($this->request->getPost('remove_gambar') === '1') { // Opsi untuk menghapus gambar tanpa upload baru
            if (!empty($ketuaProdi['gambar']) && file_exists($uploadPath . $ketuaProdi['gambar'])) {
                unlink($uploadPath . $ketuaProdi['gambar']);
            }
            $dataToUpdate['gambar'] = null;
        }


        $this->ketuaProdiModel->update($id, $dataToUpdate);

        return redirect()->to('/admin/ketua-program-studi')->with('success', 'Data Ketua Program Studi berhasil diperbarui!');
    }
}
