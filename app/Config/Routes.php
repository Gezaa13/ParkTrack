<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get ('/', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get ('/logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'role:Admin'], function ($routes) {
    $routes->get ('/', 'Admin::index');
    $routes->post('ubah-kapasitas', 'Admin::ubahKapasitas');
    $routes->get ('user', 'Admin::user');
    $routes->get ('user/get', 'Admin::getuser');
    $routes->get ('user/tambah', 'Admin::formTambahUser');
    $routes->post('user/tambah/send', 'Admin::tambahUser');
    $routes->get ('user/ubah/(:num)', 'Admin::formUbahUser/$1');
    $routes->post('user/ubah/send/(:num)', 'Admin::ubahUser/$1');
    $routes->get ('user/aktivasi/(:num)', 'Admin::aktivasiUser/$1');
    $routes->get ('kendaraan', 'Admin::kendaraan');
    $routes->get ('kendaraan/get', 'Admin::getKendaraan');
    $routes->get ('kendaraan/tambah', 'Admin::formTambahKendaraan');
    $routes->post('kendaraan/tambah/send', 'Admin::tambahKendaraan');
    $routes->get ('kendaraan/ubah/(:any)', 'Admin::formUbahKendaraan/$1');
    $routes->post('kendaraan/ubah/send/(:any)', 'Admin::ubahKendaraan/$1');
    $routes->get ('kendaraan/aktivasi/(:any)', 'Admin::aktivasiKendaraan/$1');
});

$routes->group('owner', ['filter' => 'role:Owner'], function ($routes) {
    $routes->get('/', 'Owner::index');
    $routes->get('get-data/transaksi-card/(:any)', 'Owner::getTransaksicard/$1');
    $routes->get('get-data/pendapatan-card/(:any)', 'Owner::getPendapatancard/$1');
    $routes->get('get-data/transaksi-chart/(:any)', 'Owner::getTransaksiChart/$1');
    $routes->get('get-data/pendapatan-chart/(:any)', 'Owner::getPendapatanChart/$1');
    $routes->get('get-data/table/(:any)', 'Owner::getTable/$1');
    $routes->get('export/(:any)', 'Owner::export/$1');
});

$routes->group('petugas', ['filter' => 'role:Petugas'], function ($routes) {
    $routes->get('/', 'Petugas::index');
    $routes->get('selesai/(:num)', 'Petugas::selesai/$1');
    $routes->get('cetak/(:num)', 'Petugas::cetakStruk/$1');
    $routes->get('get-masuk', 'Petugas::getMasuk');
    $routes->get('get-keluar', 'Petugas::getKeluar');
    $routes->get('get-log', 'Petugas::getLog');
});
