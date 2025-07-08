<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait; // Gunakan trait ini untuk respon JSON yang mudah
use Google\Cloud\Translate\V2\TranslateClient; // Pastikan ini diinstal via Composer

class TranslationController extends BaseController
{
    use ResponseTrait; // Menggunakan ResponseTrait untuk metode seperti $this->respond() atau $this->fail()

    public function translate()
    {
        // Pastikan request adalah POST dan AJAX (XMLHttpRequest)
        if (!$this->request->isAJAX() || $this->request->getMethod() !== 'post') {
            return $this->failUnauthorized('Akses tidak diizinkan.'); // Respon 401 Unauthorized
        }

        // Ambil CSRF token dari header
        $csrfToken = $this->request->getHeaderLine('X-CSRF-TOKEN');
        if (empty($csrfToken) || $csrfToken !== csrf_hash()) {
            return $this->failForbidden('CSRF token tidak valid.'); // Respon 403 Forbidden
        }

        $input = $this->request->getJSON(true); // Ambil data JSON dari body request

        $text        = $input['text'] ?? '';
        $target_lang = $input['target_lang'] ?? 'en'; // Default bahasa target ke 'en'

        // Validasi input
        if (empty($text) || !is_string($text)) {
            return $this->failValidationErrors('Teks sumber tidak boleh kosong atau harus berupa string.'); // Respon 400 Bad Request
        }
        if (empty($target_lang) || !in_array($target_lang, ['en'])) { // Anda bisa menambahkan 'id', 'fr', dll.
            return $this->failValidationErrors('Bahasa target tidak valid atau tidak didukung.');
        }

        // --- Panggil Google Cloud Translation API ---
        try {
            // Inisialisasi Google Cloud Translate Client
            // Anda perlu mengatur variabel lingkungan GOOGLE_APPLICATION_CREDENTIALS
            // atau menyediakan path keyfile secara langsung.
            // Contoh dengan path keyfile:
            $translate = new TranslateClient([
                'keyFile' => json_decode(file_get_contents(WRITEPATH . 'google-cloud-key.json'), true)
                // Ganti dengan path ABSOLUT ke file JSON kredensial Anda
                // Pastikan file ini tidak dapat diakses secara publik (misal di folder writable/)
            ]);

            $result = $translate->translate($text, [
                'target' => $target_lang,
                'source' => 'id' // Asumsi bahasa sumber selalu Indonesia
            ]);

            // Respon sukses
            return $this->respond(['translated_text' => $result['text']]); // Respon 200 OK

        } catch (\Google\ApiCore\ApiException $e) {
            // Tangani error spesifik dari Google Cloud API
            log_message('error', 'Google Cloud Translation API error: ' . $e->getMessage() . ' - Code: ' . $e->getCode());
            return $this->failServerError('Terjadi kesalahan pada layanan terjemahan eksternal. (' . $e->getCode() . ')'); // Respon 500 Internal Server Error

        } catch (\Exception $e) {
            // Tangani error umum lainnya
            log_message('error', 'Unexpected error in translation: ' . $e->getMessage());
            return $this->failServerError('Terjadi kesalahan tidak terduga saat menerjemahkan.'); // Respon 500 Internal Server Error
        }
    }
}
