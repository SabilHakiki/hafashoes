<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/mainmenu', 'Home::mainmenu');
$routes->get('/login', 'Home::login_view');
$routes->post('/login', 'Home::login');
$routes->post('/notification', 'Home::notification');
$routes->get('/detail_produk/(:num)', 'Home::detail_produk/$1');
$routes->get('/registrasi', 'Home::registrasi');
$routes->post('/register/user', 'Home::add');

$routes->group('', ['filter' => 'login'], function ($routes) {
    $routes->post('/edit', 'Home::edit');
    $routes->get('/logout', 'Home::logout');
    $routes->get('/contact', 'Home::contact');
    $routes->get('/profile', 'Home::profile');
    $routes->post('/editkurir', 'Home::editkurir');
    $routes->post('/addkurir', 'Home::addkurir');
    $routes->post('/updateRole', 'Home::updateRole');

    $routes->get('/produk', 'Home::produk');
    $routes->get('/addproduk', 'Home::addproduk');
    $routes->get('/updateproduk/(:num)', 'Home::updateproduk/$1');
    $routes->post('/newproduk', 'Home::newproduk');
    $routes->post('/editproduk', 'Home::editproduk');
    $routes->post('/deleteimage', 'Home::deleteimage');
    $routes->post('/hapusproduk', 'Home::hapusproduk');

    $routes->get('/kategori', 'Home::kategori');
    $routes->post('/newkategori', 'Home::newkategori');
    $routes->post('/editkategori', 'Home::editkategori');
    $routes->post('/hapuskategori', 'Home::hapuskategori');

    $routes->get('/keranjang', 'Home::keranjang');
    $routes->post('/keranjang/tambah', 'Home::tambah');
    $routes->post('/keranjang/update', 'Home::update');
    $routes->post('/keranjang/hapus', 'Home::hapus');
    $routes->get('/keranjang/hapusall', 'Home::hapusall');

    $routes->get('/checkout', 'Home::checkout');
    $routes->post('/getKota', 'Home::getKota');
    $routes->post('/getOngkir', 'Home::getOngkir');
    $routes->post('getAlamatAutocomplete', 'Home::getAlamatAutocomplete');


    $routes->get('/midtrans', 'Home::midtrans');
    $routes->post('/processPayment', 'Home::processPayment');
    $routes->post('/clear', 'Home::clear');

    $routes->get('/transaksi', 'Home::transaksi');
    $routes->get('transaksi/details/(:num)', 'Home::transaksi_detail/$1');
    $routes->get('transaksi/invoice/(:num)', 'Home::invoice/$1');
    $routes->get('transaksi/print/(:num)', 'Home::cetakPdf/$1');

    $routes->get('/laporan', 'Home::laporan');
    $routes->get('/laporan/cetakLaporan', 'Home::cetakLaporan');

    $routes->get('/kurir', 'Home::kurir');
    $routes->post('/kurir/ambilPesanan', 'Home::ambilPesanan');
    $routes->post('/kurir/update_status', 'Home::updateStatus');
    $routes->post('transaksi/inputResi/(:num)', 'Home::inputResi/$1');
    $routes->get('/kurir/history', 'KurirController::history');
});
