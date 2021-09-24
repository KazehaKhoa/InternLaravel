<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/admin/order/index', [App\Http\Controllers\OrderManagementController::class, 'indexAdmin'])->middleware('is_admin');
Route::get('/admin/order/add', [App\Http\Controllers\OrderManagementController::class, 'add'])->middleware('is_admin');
Route::post('/admin/order/', [App\Http\Controllers\OrderManagementController::class, 'store'])->middleware('is_admin');
Route::get('/orderM/{user}', [App\Http\Controllers\OrderManagementController::class, 'index']);
Route::get('/order/{order}', [App\Http\Controllers\OrderController::class, 'index']);