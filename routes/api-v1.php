<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\Auth\LoginController;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

/* Route::get('/prueba', function () {
    return "prueba";
}); */

Route::post('register', [RegisterController::class, 'store'])->name('api.v1.register');
Route::post('login', [LoginController::class, 'store']);

//Creamos las rutas para el controlador de categorias
Route::apiResource('categories', CategoryController::class)->names('api.v1.categories');
//Creamos las rutas para el controlador de Posts
Route::apiResource('posts', PostController::class)->names('api.v1.posts');