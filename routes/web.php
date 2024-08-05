<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresuController;
use App\Http\Controllers\TarjetaController;
use App\Http\Controllers\MaterialesController;
use App\Http\Controllers\ManodeobraController;
use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\AuxiController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
  return view('welcome');
})->name('welcome');

Route::get('/inicio', function () { 
  return view('inicio'); 
})->name('inicio');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

  require __DIR__.'/auth.php';

  // ---------------rutas de vistas con CRUDS y controller------------
Route::middleware('auth')->group(function () {
  Route::resource('dashboard', DashboardController::class)->name('dashboard.index', 'dashboard');

  Route::resource('presus', PresuController::class);
  Route::get('/editPresupuesto/{id}', [PresuController::class, 'edit'])->name('editPresupuesto');
  Route::post('/updateConceptoCantidad/{id}', [PresuController::class, 'updateConceptoCantidad'])->name('updateConceptoCantidad');
  
  Route::resource('tarjetas', TarjetaController::class);
  Route::resource('materiales', MaterialesController::class);
  Route::resource('manodeobra', ManodeobraController::class);
  Route::resource('herramientas', HerramientaController::class);
  Route::resource('auxis', AuxiController::class);
  
});


// -----------------ruta para metodo individual------------------
//GET -- visible por URL - para recuperar datos en vista
//POST -- ocultos en el cuerpo - para almacenar datos en la BD




