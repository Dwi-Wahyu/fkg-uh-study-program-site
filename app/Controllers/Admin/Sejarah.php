<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SejarahModel; // Pastikan model sudah di-import

class Sejarah extends BaseController
{
    protected $sejarahModel;

    public function __construct()
    {
        $this->sejarahModel = new SejarahModel();
        helper(['form', 'url']); // Muat helper yang dibutuhkan
    }

    // Metode utama untuk menampilkan/mengedit data (selalu ID 1)
    public function index()
    {
        $dataContent = $this->sejarahModel->find(1);

        // Jika data belum ada (meskipun migration seed seharusnya sudah membuatnya)
        if (!$dataContent) {
            $dataDefault = [
                'content'    => 'Ini adalah konten sejarah default dalam Bahasa Indonesia. Silakan perbarui.',
                'content_en' => 'This is your default history content in English. Please update.',
            ];
            $this->sejarahModel->save($dataDefault);
            $dataContent = $this->sejarahModel->find(1);
        }

        $data = [
            'title'       => 'Pengaturan Sejarah',
            'dataContent' => $dataContent, // Menggunakan nama variabel yang lebih umum
            'errors'      => session()->getFlashdata('errors'),
            'success'     => session()->getFlashdata('success'),
        ];
        return view('admin/sejarah/index', $data); // Langsung ke form edit
    }

    // Metode untuk memproses pembaruan data
    public function update()
    {
        $id = 1; // Selalu perbarui baris dengan ID 1
        $dataContent = $this->sejarahModel->find($id);

        if (!$dataContent) {
            return redirect()->to('/admin/sejarah')->with('errors', ['Data Sejarah tidak ditemukan.']);
        }

        $rules = [
            'content'    => 'permit_empty', // Biarkan kosong jika tidak wajib
            'content_en' => 'permit_empty', // Biarkan kosong jika tidak wajib
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataToUpdate = [
            'content'    => $this->request->getPost('content'),
            'content_en' => $this->request->getPost('content_en'),
        ];

        $this->sejarahModel->update($id, $dataToUpdate);

        return redirect()->to('/admin/sejarah')->with('success', 'Konten Sejarah berhasil diperbarui!');
    }
}
