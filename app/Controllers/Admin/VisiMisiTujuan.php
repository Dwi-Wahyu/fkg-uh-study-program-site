<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VisiMisiTujuanModel;

class VisiMisiTujuan extends BaseController
{
    protected $visiMisiTujuanModel;

    public function __construct()
    {
        $this->visiMisiTujuanModel = new VisiMisiTujuanModel();
        helper(['form', 'url']); // Muat helper yang dibutuhkan
    }

    // Metode utama untuk menampilkan/mengedit data (selalu ID 1)
    public function index()
    {
        $dataContent = $this->visiMisiTujuanModel->find(1);

        // Jika data belum ada (meskipun migration seed seharusnya sudah membuatnya)
        if (!$dataContent) {
            $dataDefault = [
                'visi_id'   => 'Visi default Anda dalam Bahasa Indonesia.',
                'visi_en'   => 'Your default Vision in English.',
                'misi_id'   => 'Misi default Anda dalam Bahasa Indonesia.',
                'misi_en'   => 'Your default Mission in English.',
                'tujuan_id' => 'Tujuan default Anda dalam Bahasa Indonesia.',
                'tujuan_en' => 'Your default Goal in English.',
            ];
            $this->visiMisiTujuanModel->save($dataDefault);
            $dataContent = $this->visiMisiTujuanModel->find(1);
        }

        $data = [
            'title'       => 'Pengaturan Visi, Misi & Tujuan',
            'dataContent' => $dataContent, // Menggunakan nama variabel yang lebih umum
            'errors'      => session()->getFlashdata('errors'),
            'success'     => session()->getFlashdata('success'),
        ];
        return view('admin/visi-misi-tujuan/index', $data); // Langsung ke form edit
    }

    // Metode untuk memproses pembaruan data
    public function update()
    {
        $id = 1; // Selalu perbarui baris dengan ID 1
        $dataContent = $this->visiMisiTujuanModel->find($id);

        if (!$dataContent) {
            return redirect()->to('/admin/visi-misi-tujuan')->with('errors', ['Data Visi, Misi & Tujuan tidak ditemukan.']);
        }

        $rules = [
            'visi_id'   => 'permit_empty', // Visi ID bisa kosong atau wajib
            'visi_en'   => 'permit_empty', // Visi EN bisa kosong
            'misi_id'   => 'permit_empty',
            'misi_en'   => 'permit_empty',
            'tujuan_id' => 'permit_empty',
            'tujuan_en' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataToUpdate = [
            'visi_id'   => $this->request->getPost('visi_id'),
            'visi_en'   => $this->request->getPost('visi_en'),
            'misi_id'   => $this->request->getPost('misi_id'),
            'misi_en'   => $this->request->getPost('misi_en'),
            'tujuan_id' => $this->request->getPost('tujuan_id'),
            'tujuan_en' => $this->request->getPost('tujuan_en'),
        ];

        $this->visiMisiTujuanModel->update($id, $dataToUpdate);

        return redirect()->to('/admin/visi-misi-tujuan')->with('success', 'Konten Visi, Misi & Tujuan berhasil diperbarui!');
    }
}
