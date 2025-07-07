<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/login', 'Auth::login');
$routes->match(['get', 'post'], '/register', 'Auth::register');
$routes->match(['get', 'post'], '/login', 'Auth::login');

$routes->group('admin', function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Grup menu berita
    $routes->group('berita', function ($routes) {
        $routes->get('/', 'Admin\Berita::index'); // /admin/berita
        $routes->get('create', 'Admin\Berita::create'); // /admin/berita/create
        $routes->post('store', 'Admin\Berita::store'); // /admin/berita/store
        $routes->get('edit/(:num)', 'Admin\Berita::edit/$1'); // /admin/berita/edit/5
        $routes->post('update/(:num)', 'Admin\Berita::update/$1'); // /admin/berita/update/5
        $routes->get('delete/(:num)', 'Admin\Berita::delete/$1'); // /admin/berita/delete/5
    });

    // Grup pengguna (jika ada)
    $routes->group('users', ['filter' => 'auth'], function ($routes) {
        $routes->get('/', 'Admin\Users::index');
        $routes->match(['get', 'post'], 'create', 'Admin\Users::create');
        $routes->match(['get', 'post'], 'edit/(:num)', 'Admin\Users::edit/$1');
        $routes->get('delete/(:num)', 'Admin\Users::delete/$1');
    });

    // Menu lain
    $routes->get('media-berita', 'Admin\MediaBerita::index');
    $routes->get('student-activity', 'Admin\StudentActivity::index');
    $routes->get('gallery', 'Admin\Gallery::index');
});
