<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RegistarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/registar', [RegistarController::class, 'registar']);
Route::post('/login', [RegistarController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('/products', ProductController::class);
    Route::get('/logout', [RegistarController::class, 'logout']);
});
