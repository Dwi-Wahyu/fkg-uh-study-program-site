<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {

        $isLoggedIn = session()->get('isLoggedIn');
        log_message('debug', 'AuthFilter: isLoggedIn status - ' . ($isLoggedIn ? 'TRUE' : 'FALSE'));

        if (! $isLoggedIn) {
            log_message('debug', 'AuthFilter: Redirecting to login because not logged in.');
            return redirect()->to('/login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        } else {
            log_message('debug', 'AuthFilter: User is logged in, proceeding to ' . $request->getUri()->getPath());
        }

        // Periksa apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            // Jika belum login, redirect ke halaman login
            return redirect()->to('/login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
