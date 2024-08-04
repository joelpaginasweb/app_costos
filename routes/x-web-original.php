<?php
use App\Http\Controllers\DashboController;
use App\Http\Controllers\PresuController;
use App\Http\Controllers\TarjetaController;
use App\Http\Controllers\MaterialesController;
use App\Http\Controllers\ManodeobraController;
use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\AuxiController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// ---------------------------------------//
Route::get('/inicio', function () { 
  return view('inicio'); 
})->name('landing');

  // ---------------rutas de vistas con CRUDS y controller------------
Route::resource('dashbos', DashboController::class);
Route::resource('presus', PresuController::class);
Route::resource('tarjetas', TarjetaController::class);
Route::resource('materiales', MaterialesController::class);
Route::resource('manodeobra', ManodeobraController::class);
Route::resource('herramientas', HerramientaController::class);
Route::resource('auxis', AuxiController::class);
