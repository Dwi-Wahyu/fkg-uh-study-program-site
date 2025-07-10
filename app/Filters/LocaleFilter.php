<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\App;

class LocaleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        /** @var \CodeIgniter\HTTP\IncomingRequest $request */

        $locale = $request->getUri()->getSegment(1);

        $config = config(App::class);
        $supportedLocales = $config->supportedLocales ?? ['en', 'id'];

        if (in_array($locale, $supportedLocales)) {
            $request->setLocale($locale);

            $pathSegments = $request->getUri()->getSegments();
            array_shift($pathSegments); // Hapus segmen locale

            // --- PERBAIKAN DI SINI ---
            $newPath = implode('/', $pathSegments);
            if ($newPath === '') { // Jika path menjadi kosong setelah menghapus locale
                $newPath = '/'; // Set menjadi root path
            }
            // --- AKHIR PERBAIKAN ---

            $request->getUri()->setPath($newPath);
        } else {
            // Jika tidak ada segmen locale atau tidak didukung, gunakan locale default
            $request->setLocale($config->defaultLocale);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
