<?php

use App\Http\Controllers\CityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// GET Menampilkan seluruh data dalam 1 table.
    Route::get('/city', [CityController::class, 'get_city']);

// GET Menampilkan beberapa data dengan menggunakan Parameter (id provinsi)
    Route::get('/city/{id}', [CityController::class, 'get_city_by_province']);

// POST Menginput data pada 1 table.
    Route::post('/city', [CityController::class, 'store_city']);

//  POST Menginput data pada lebih dari 1 table.
    Route::post('/city-province', [CityController::class, 'store_city_province']);

//  PUT Mengupdate data pada kolom tertentu dalam suatu table.
    Route::put('/city/{id}', [CityController::class, 'update_city']);

//  DELETE Menghapus 1 baris data dalam table tertentu.
    Route::delete('/city/{id}', [CityController::class, 'delete_city']);
