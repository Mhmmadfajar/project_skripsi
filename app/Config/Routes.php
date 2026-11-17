<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public / Auth Routes
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::attemptRegister');
$routes->get('/logout', 'Auth::logout');

// Public verification for QR Code on printed letters
$routes->get('/verifikasi/surat/(:any)', 'Verifikasi::surat/$1');

// Public self-service letter tracking
$routes->get('/lacak-surat', 'Surat::lacak');
$routes->post('/lacak-surat', 'Surat::lacak');

// Authenticated Routes
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Dashboard & Profil
    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/profil', 'User::profil');
    $routes->post('/profil', 'User::updateProfil');

    // Layanan Surat (All roles have access, filtered by role in controller)
    $routes->get('/surat', 'Surat::index');
    $routes->get('/surat/tambah', 'Surat::create');
    $routes->post('/surat/simpan', 'Surat::store');
    $routes->get('/surat/detail/(:num)', 'Surat::detail/$1');
    $routes->get('/surat/cetak/(:num)', 'Surat::cetak/$1');
    
    // Surat Process & Approval
    $routes->get('/surat/proses/(:num)', 'Surat::proses/$1', ['filter' => 'role:admin,staf']);
    $routes->post('/surat/approve/(:num)', 'Surat::approve/$1', ['filter' => 'role:kades']);
    $routes->post('/surat/reject/(:num)', 'Surat::reject/$1', ['filter' => 'role:admin,kades']);

    // Admin & Staf & Kades only: Kependudukan, Kartu Keluarga, Mutasi, Laporan
    $routes->group('', ['filter' => 'role:admin,staf,kades'], static function ($routes) {
        // Penduduk
        $routes->get('/penduduk', 'Penduduk::index');
        $routes->get('/penduduk/detail/(:any)', 'Penduduk::detail/$1');
        $routes->get('/penduduk/tambah', 'Penduduk::create');
        $routes->post('/penduduk/simpan', 'Penduduk::store');
        $routes->get('/penduduk/edit/(:any)', 'Penduduk::edit/$1');
        $routes->post('/penduduk/update/(:any)', 'Penduduk::update/$1');
        $routes->get('/penduduk/hapus/(:any)', 'Penduduk::delete/$1');
        $routes->get('/penduduk/export', 'Penduduk::export');
        $routes->get('/penduduk/template', 'Penduduk::downloadTemplate');
        $routes->post('/penduduk/import', 'Penduduk::import');

        // Kartu Keluarga
        $routes->get('/kartu-keluarga', 'KartuKeluarga::index');
        $routes->get('/kartu-keluarga/detail/(:any)', 'KartuKeluarga::detail/$1');
        $routes->get('/kartu-keluarga/cetak/(:any)', 'KartuKeluarga::cetak/$1');
        $routes->get('/kartu-keluarga/tambah', 'KartuKeluarga::create');
        $routes->post('/kartu-keluarga/simpan', 'KartuKeluarga::store');
        $routes->get('/kartu-keluarga/edit/(:any)', 'KartuKeluarga::edit/$1');
        $routes->post('/kartu-keluarga/update/(:any)', 'KartuKeluarga::update/$1');
        $routes->get('/kartu-keluarga/hapus/(:any)', 'KartuKeluarga::delete/$1');

        // Mutasi Penduduk
        $routes->get('/mutasi', 'Mutasi::index');
        $routes->get('/mutasi/tambah', 'Mutasi::create');
        $routes->post('/mutasi/simpan', 'Mutasi::store');
        $routes->get('/mutasi/hapus/(:num)', 'Mutasi::delete/$1');

        // Laporan & Statistik
        $routes->get('/laporan', 'Laporan::index');
        $routes->get('/laporan/cetak', 'Laporan::cetak');
    });

    // Admin only: Manajemen User
    $routes->group('', ['filter' => 'role:admin'], static function ($routes) {
        $routes->get('/user', 'User::index');
        $routes->get('/user/tambah', 'User::create');
        $routes->post('/user/simpan', 'User::store');
        $routes->get('/user/toggle/(:num)', 'User::toggleActive/$1');
    });
});
