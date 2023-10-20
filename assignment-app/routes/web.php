<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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
Route::group(['middleware' => 'isAdmin'], function () {
    Route::get('/admin/dashboard', function () {
        return view('adminDashboard');
    });
});
Route::post('/api/products', [ProductController::class, 'store'] );
Route::get('/api/users', [UserController::class, 'view']);