<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PesananController;
use App\Http\Controllers\API\RuteController;
use App\Http\Controllers\API\PembayaranController;
use App\Http\Controllers\API\Detail_PesananController;
use App\Http\Controllers\API\Metode_PembayaranController;

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

//login&register
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);


 //pesanan
 Route::get('pesanan', [PesananController::class, 'index']);
 Route::post('pesanan/store', [PesananController::class, 'store'])->middleware(['auth:sanctum']);
 Route::post('pesanan/update/{id}', [PesananController::class, 'update']);
 Route::get('pesanan/show/{id}', [PesananController::class, 'show']);
 Route::get('pesanan/destroy/{id}', [PesananController::class, 'destroy']);

//rute
Route::get('rute', [RuteController::class, 'index']);
Route::post('rute/store', [RuteController::class, 'store']);
Route::post('rute/update/{id}', [RuteController::class, 'update']);
Route::get('rute/show/{id}', [RuteController::class, 'show']);
Route::get('rute/destroy/{id}', [RuteController::class, 'destroy']);

//pembayaran
Route::get('pembayaran', [PembatalanController::class, 'index']);
Route::post('pembayaran/store', [PembatalanController::class, 'store']);
Route::post('pembayaran/update/{id}', [PembatalanController::class, 'update']);
Route::get('pembayaran/show/{id}', [PembatalanController::class, 'show']);
Route::get('pembayaran/destroy/{id}', [PembatalanController::class, 'destroy']);

//detail_pesanan
Route::get('detail_pesanan', [Detail_PesananController::class, 'index']);
Route::post('detail_pesanan/store', [Detail_PesananController::class, 'store']);
Route::post('detail_pesanan/update/{id}', [Detail_PesananController::class, 'update']);
Route::get('detail_pesanan/show/{id}', [Detail_PesananController::class, 'show']);
Route::get('detail_pesanan/destroy/{id}', [Detail_PesananController::class, 'destroy']);

//metode_pembayaran
Route::get('metode_pembayaran', [Metode_PembayaranController::class, 'index']);
Route::post('metode_pembayaran', [Metode_PembayaranController::class, 'store']);
Route::post('metode_pembayaran/update/{id}', [Metode_PembayaranController::class, 'update']);
Route::get('metode_pembayaran/show/{id}', [Metode_PembayaranController::class, 'show']);
Route::get('metode_pembayaran/destroy/{id}', [Metode_PembayaranController::class, 'destroy']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    Route::get('user', [UserController::class, 'fetch']);
    Route::post('user', [UserController::class, 'updateProfile']);
    Route::post('logout', [UserController::class, 'logout']);


});



