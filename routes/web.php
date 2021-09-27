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
//show all order for admin
Route::get('/admin/order', [App\Http\Controllers\OrderManagementController::class, 'showAdmin'])->name('admin.orders')->middleware('is_admin');
//add order by admin
Route::get('/admin/order/add', [App\Http\Controllers\OrderController::class, 'add'])->middleware('is_admin');
Route::post('/admin/order', [App\Http\Controllers\OrderController::class, 'store'])->middleware('is_admin');
//show all order of that user
Route::get('/orderM/{user}', [App\Http\Controllers\OrderManagementController::class, 'index']);
//show an order for admin or user of that order
Route::get('/order/{order}', [App\Http\Controllers\OrderController::class, 'index']);
//edit state of order by admin
Route::get('/order/{order}/edit', [App\Http\Controllers\OrderController::class, 'edit'])->name('order.edit')->middleware('is_admin');
Route::patch('/order/{order}', [App\Http\Controllers\OrderController::class, 'update'])->middleware('is_admin');
//delete order by admin
Route::delete('/order/{order}/delete', [App\Http\Controllers\OrderController::class, 'destroy'])->name('order.destroy')->middleware('is_admin');
