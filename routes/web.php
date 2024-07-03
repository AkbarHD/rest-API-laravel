<?php

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

Route::get('/list-provinsi', function () {
    // return ('list privinsi indonesia');
    $response = Http::withHeaders([
        'key' => 'd19c27e0d7ff4966d18cc47ddd5900ae',
    ])->get('https://api.rajaongkir.com/starter/province');
    // return $response->json();

    dd($response->json()['rajaongkir']);
});
