<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PengirimanController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('books', [BookController::class, 'index'])->name('books');
Route::get('books/export/excel', [BookController::class, 'export_excel'])->name('books')->name('export-excell');
Route::get('export-pdf', [BookController::class, 'exportPdf'])->name('export-pdf');

Route::get('/list-provinsi', function () {
    // return ('list privinsi indonesia');
    $response = Http::withHeaders([
        'key' => 'd19c27e0d7ff4966d18cc47ddd5900ae',
    ])->get('https://api.rajaongkir.com/starter/province');
    // return $response->json();

    dd($response->json()['rajaongkir']);
});

// akses api laravel
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
// url tambah buku ini harus sama yaag di api.php
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::get('/buku/{id}', [BukuController::class, 'show'])->name('buku.show');
Route::put('/buku/{id}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/deletebuku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');
