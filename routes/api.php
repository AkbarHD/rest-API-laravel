<?php

use App\Http\Controllers\Api\BukuController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/login', [AuthenticationController::class, 'login']);

// punya cara fajar
Route::middleware(['auth:sanctum'])->group(function () {
    // user tdk boleh akses ini jika belum login atau tidak punya token
    Route::get('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/me', [AuthenticationController::class, 'me']);
    Route::post('/posts/store', [PostController::class, 'store']);
    Route::patch('/posts/update/{id}', [PostController::class, 'update'])->middleware('pemilik-postingan');
    Route::delete('/posts/delete/{id}', [PostController::class, 'destroy'])->middleware('pemilik-postingan');

    // comment
    Route::post('/comment', [CommentController::class, 'store']);
    Route::patch('/comment/{id}', [CommentController::class, 'update'])->middleware('pemilik-komentar');
    Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->middleware('pemilik-komentar');
});

// progamming dirumah affif
Route::get('/buku', [BukuController::class, 'index']);
Route::get('/buku/{id}', [BukuController::class, 'show']);
// url tambah buku ini harus sama yaa di web.php
Route::post('/buku', [BukuController::class, 'store']);
Route::put('/buku/{id}', [BukuController::class, 'update']);
Route::delete('/deletebuku/{id}', [BukuController::class, 'destroy']);
