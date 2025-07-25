<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KlienController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\DivisiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisAkunController;
use App\Http\Controllers\JenisTiketController;
use App\Http\Controllers\LevelKlienController;
use App\Http\Controllers\TugasRutinController;
use App\Http\Controllers\TiketBelumTerselesaikanController;

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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('loginProcess');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth']);
Route::resource('/divisi', DivisiController::class)->middleware(['auth']);
Route::resource('/jabatan', JabatanController::class)->middleware(['auth']);
Route::resource('/user', UserController::class)->middleware(['auth']);
Route::resource('/progress', ProgressController::class)->middleware(['auth']);
Route::resource('/jenis_tiket', JenisTiketController::class)->middleware(['auth']);
Route::resource('/level_klien', LevelKlienController::class)->middleware(['auth']);
Route::resource('/jenis_akun', JenisAkunController::class)->middleware(['auth']);
Route::resource('/klien', KlienController::class)->middleware(['auth']);
Route::resource('/produk', ProdukController::class)->middleware(['auth']);
Route::resource('/tiket', TiketController::class)->middleware(['auth']);
Route::resource('/tugas_rutin', TugasRutinController::class)->middleware(['auth']);
Route::resource('tugas', TugasController::class)
    ->parameters(['tugas' => 'tugas'])
    ->middleware(['auth']);
Route::resource('/akun', AkunController::class)->middleware(['auth']);


// API
Route::get('/todo', [TodoController::class, 'index'])->name('todo');
Route::post('/todo/update-progress', [TodoController::class, 'updateProgress'])->name('todo.update-progress');
Route::get('/tiket-belum-terselesaikan', [TiketBelumTerselesaikanController::class, 'index'])->name('tiket.belum-selesai');
Route::post('/tiket/update-progress', [TiketBelumTerselesaikanController::class, 'updateProgress'])->name('tiket.update-progress');
