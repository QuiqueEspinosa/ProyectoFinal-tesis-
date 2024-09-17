<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\InvitadoController;

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





Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/index', function () {
    return view('index');  // Aquí 'index' es el nombre del archivo 'index.blade.php'
})->name('index');


 Route::middleware('auth')->group(function () {
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::post('/update-positions', [ConfigController::class, 'updatePositions'])->name('updatePositions');

Route::resource('config', ConfigController::class);
Route::post('/mesas/ordenar', [MesaController::class, 'ordenar']);
Route::post('/update-positions', [ConfigController::class, 'updatePositions']);


Route::post('/admin/add-table', [AdminController::class, 'addTable'])->name('admin.addTable');
Route::post('/admin/remove-last-table', [AdminController::class, 'removeLastTable'])->name('admin.removeLastTable');
Route::get('/mesas/{id}/info', [AdminController::class, 'getMesaInfo']);

Route::resource('invitados', InvitadoController::class);
Route::get('/lista-invitados', [InvitadoController::class, 'listaInvitados'])->name('listaInvitados');
Route::get('/export-pdf', [InvitadoController::class, 'exportPDF'])->name('invitados.exportPDF');

 });