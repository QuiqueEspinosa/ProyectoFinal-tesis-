<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\MesaController;
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

Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/update-positions', [ConfigController::class, 'updatePositions'])->name('updatePositions');

Route::resource('config', ConfigController::class);
Route::post('/mesas/ordenar', [MesaController::class, 'ordenar']);
Route::post('/update-positions', [ConfigController::class, 'updatePositions']);




Route::post('/admin/add-table', [AdminController::class, 'addTable'])->name('admin.addTable');
Route::post('/admin/remove-last-table', [AdminController::class, 'removeLastTable'])->name('admin.removeLastTable');
