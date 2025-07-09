<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/sejarah', 'Home::sejarah');

$routes->get('/login', 'Auth::login'); // Pastikan Anda juga punya POST /login
$routes->post('/login', 'Auth::login'); // Tambahkan jika belum ada

$routes->get('berita/(:num)', 'Admin\Berita::detail/$1');

$routes->get('/logout', 'Auth::logout');

$routes->group('api', function ($routes) {
    $routes->post('translate', 'Api\TranslationController::translate');
});

$routes->group('admin', ['filter' => 'auth'], function ($routes) { // <-- Filter 'auth' ditambahkan di sini
    $routes->get('/', 'Admin\Dashboard::index'); // Sekarang ini dilindungi
    $routes->get('dashboard', 'Admin\Dashboard::index'); // Sekarang ini dilindungi

    $routes->group('visi-misi-tujuan', function ($routes) {
        $routes->get('/', 'Admin\VisiMisiTujuan::index');
        $routes->post('update', 'Admin\VisiMisiTujuan::update');
    });

    $routes->group('berita', function ($routes) {
        $routes->get('/', 'Admin\Berita::index');
        $routes->get('create', 'Admin\Berita::create');
        $routes->post('store', 'Admin\Berita::store');
        $routes->get('edit/(:num)', 'Admin\Berita::edit/$1');
        $routes->post('update/(:num)', 'Admin\Berita::update/$1');
        $routes->get('delete/(:num)', 'Admin\Berita::delete/$1');
    });

    $routes->group('users', function ($routes) {
        $routes->get('/', 'Admin\Users::index');
        $routes->match(['get', 'post'], 'create', 'Admin\Users::create');
        $routes->match(['get', 'post'], 'edit/(:num)', 'Admin\Users::edit/$1');
        $routes->get('delete/(:num)', 'Admin\Users::delete/$1');
    });

    $routes->group('media-berita', function ($routes) {
        $routes->get('/', 'Admin\MediaBerita::index');
        $routes->get('create', 'Admin\MediaBerita::create');
        $routes->post('store', 'Admin\MediaBerita::store');
        $routes->get('delete/(:num)', 'Admin\MediaBerita::delete/$1');
    });

    $routes->group('profil-lulusan', function ($routes) {
        $routes->get('/', 'Admin\ProfilLulusan::index');
        $routes->get('create', 'Admin\ProfilLulusan::create');
        $routes->post('store', 'Admin\ProfilLulusan::store');
        $routes->get('edit/(:num)', 'Admin\ProfilLulusan::edit/$1');
        $routes->post('update/(:num)', 'Admin\ProfilLulusan::update/$1');
        $routes->get('delete/(:num)', 'Admin\ProfilLulusan::delete/$1');
    });

    $routes->group('student-activity', function ($routes) {
        $routes->get('/', 'Admin\StudentActivity::index');
        $routes->get('create', 'Admin\StudentActivity::create');
        $routes->post('store', 'Admin\StudentActivity::store');
        $routes->get('edit/(:num)', 'Admin\StudentActivity::edit/$1');
        $routes->post('update/(:num)', 'Admin\StudentActivity::update/$1');
        $routes->get('delete/(:num)', 'Admin\StudentActivity::delete/$1');
    });

    $routes->group('sarana-prasarana', function ($routes) {
        $routes->get('/', 'Admin\SaranaPrasarana::index');
        $routes->get('create', 'Admin\SaranaPrasarana::create');
        $routes->post('store', 'Admin\SaranaPrasarana::store');
        $routes->get('edit/(:num)', 'Admin\SaranaPrasarana::edit/$1');
        $routes->post('update/(:num)', 'Admin\SaranaPrasarana::update/$1');
        $routes->get('delete/(:num)', 'Admin\SaranaPrasarana::delete/$1');
    });

    $routes->group('ketua-program-studi', function ($routes) {
        $routes->get('/', 'Admin\KetuaProgramStudi::index');
        $routes->post('update', 'Admin\KetuaProgramStudi::update');
    });

    $routes->group('sejarah', function ($routes) { // Tidak perlu filter 'auth' di sini karena sudah diwarisi dari grup induk 'admin'
        $routes->get('/', 'Admin\Sejarah::index'); // Menampilkan form edit
        $routes->post('update', 'Admin\Sejarah::update'); // Memproses pembaruan
    });
});
