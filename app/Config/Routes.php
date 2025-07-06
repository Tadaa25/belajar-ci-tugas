<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

// Auth
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// Produk
$routes->group('produk', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

// Paket
$routes->group('paket', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'PaketController::index');
    $routes->post('', 'PaketController::create');
    $routes->post('edit/(:any)', 'PaketController::edit/$1');
    $routes->get('delete/(:any)', 'PaketController::delete/$1');
    $routes->get('download', 'PaketController::download');
});

// Keranjang & Transaksi (Hybrid: Form + API)
$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index'); // v_keranjang
    $routes->post('', 'TransaksiController::cart_add'); // Form submit (optional jika pakai API)
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);

// API Keranjang (JSON only, untuk tombol beli JS)
$routes->resource('api/keranjang', ['controller' => 'API\KeranjangAPI']);
$routes->get('checkout', 'TransaksiController::checkout');
$routes->post('checkout', 'TransaksiController::buy');
$routes->get('riwayat', 'TransaksiController::riwayat', ['filter' => 'adminonly']);




// Opsional Rajaongkir (jika masih dipakai)
//$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
//$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);
