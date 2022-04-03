<?php

use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\PenerimaanDanaController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\UserController;
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
Route::group(['middleware' => ['auth']], function(){
    Route::get('/', function () {
        return view('dashboard');
    });
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('user', UserController::class);
    Route::resource('masyarakat', MasyarakatController::class);
    Route::get('pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::delete('pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
    Route::resource('penerimaan-dana', PenerimaanDanaController::class);
});

require __DIR__.'/auth.php';
