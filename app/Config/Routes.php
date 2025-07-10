<?php

use CodeIgniter\Router\RouteCollection;
use Config\App; // Pastikan ini ada untuk mengakses konfigurasi App

/**
 * @var RouteCollection $routes
 */

$supportedLocales = config(App::class)->supportedLocales ?? ['en', 'id'];
$routes->addPlaceholder('locale', implode('|', $supportedLocales));

$routes->GET('/', 'Home::index');
$routes->GET('sejarah', 'Home::sejarah');
$routes->GET('student-guide', 'Home::student_guide');
$routes->GET('sarana-dan-prasarana', 'Home::sarana_dan_prasarana');
$routes->GET('survei', 'Home::survei');
$routes->GET('graduate-profile', 'Home::profil_lulusan');
$routes->GET('curriculum', 'Home::kurikulum');
$routes->GET('aktivitas-residen', 'Home::resident_activity');

$routes->GET('/login', 'Auth::login');
$routes->POST('/login', 'Auth::login');

$routes->GET('/berita/(:num)', 'Admin\Berita::detail/$1');
$routes->GET('/logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->GET('/', 'Admin\Dashboard::index');
    $routes->GET('dashboard', 'Admin\Dashboard::index');

    $routes->group('visi-misi-tujuan', function ($routes) {
        $routes->GET('/', 'Admin\VisiMisiTujuan::index');
        $routes->POST('update', 'Admin\VisiMisiTujuan::update');
    });

    $routes->group('berita', function ($routes) {
        $routes->GET('/', 'Admin\Berita::index');
        $routes->GET('create', 'Admin\Berita::create');
        $routes->POST('store', 'Admin\Berita::store');
        $routes->GET('edit/(:num)', 'Admin\Berita::edit/$1');
        $routes->POST('update/(:num)', 'Admin\Berita::update/$1');
        $routes->GET('delete/(:num)', 'Admin\Berita::delete/$1');
    });

    $routes->group('media-berita', function ($routes) {
        $routes->GET('/', 'Admin\MediaBerita::index');
        $routes->GET('create', 'Admin\MediaBerita::create');
        $routes->POST('store', 'Admin\MediaBerita::store');
        $routes->GET('delete/(:num)', 'Admin\MediaBerita::delete/$1');
    });

    $routes->group('profil-lulusan', function ($routes) {
        $routes->GET('/', 'Admin\ProfilLulusan::index');
        $routes->GET('create', 'Admin\ProfilLulusan::create');
        $routes->POST('store', 'Admin\ProfilLulusan::store');
        $routes->GET('edit/(:num)', 'Admin\ProfilLulusan::edit/$1');   // <-- Pastikan ini sudah ada dan benar
        $routes->POST('update/(:num)', 'Admin\ProfilLulusan::update/$1'); // <-- Pastikan ini sudah ada dan benar
        $routes->GET('delete/(:num)', 'Admin\ProfilLulusan::delete/$1');
    });

    $routes->group('resident-activity', function ($routes) {
        $routes->GET('/', 'Admin\ResidentActivity::index');
        $routes->GET('create', 'Admin\ResidentActivity::create');
        $routes->POST('store', 'Admin\ResidentActivity::store');
        $routes->GET('edit/(:num)', 'Admin\ResidentActivity::edit/$1');
        $routes->POST('update/(:num)', 'Admin\ResidentActivity::update/$1');
        $routes->GET('delete/(:num)', 'Admin\ResidentActivity::delete/$1');
    });

    $routes->group('sarana-prasarana', function ($routes) {
        $routes->GET('/', 'Admin\SaranaPrasarana::index');
        $routes->GET('create', 'Admin\SaranaPrasarana::create');
        $routes->POST('store', 'Admin\SaranaPrasarana::store');
        $routes->GET('edit/(:num)', 'Admin\SaranaPrasarana::edit/$1');
        $routes->POST('update/(:num)', 'Admin\SaranaPrasarana::update/$1');
        $routes->GET('delete/(:num)', 'Admin\SaranaPrasarana::delete/$1');
    });

    $routes->group('ketua-program-studi', function ($routes) {
        $routes->GET('/', 'Admin\KetuaProgramStudi::index');
        $routes->POST('update', 'Admin\KetuaProgramStudi::update');
    });

    $routes->group('sejarah', function ($routes) {
        $routes->GET('/', 'Admin\Sejarah::index');
        $routes->POST('update', 'Admin\Sejarah::update');
    });

    $routes->group('kurikulum', function ($routes) {
        $routes->GET('/', 'Admin\Kurikulum::index');
        $routes->GET('create', 'Admin\Kurikulum::create');
        $routes->POST('store', 'Admin\Kurikulum::store');
        $routes->GET('delete/(:num)', 'Admin\Kurikulum::delete/$1');
    });

    $routes->group('survei', function ($routes) { // Ubah nama grup route
        $routes->get('/', 'Admin\Survei::index');
        $routes->get('create', 'Admin\Survei::create');
        $routes->post('store', 'Admin\Survei::store');
        $routes->get('edit/(:num)', 'Admin\Survei::edit/$1');
        $routes->post('update/(:num)', 'Admin\Survei::update/$1');
        $routes->get('delete/(:num)', 'Admin\Survei::delete/$1');
    });
});
