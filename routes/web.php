<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresuController;
use App\Http\Controllers\TarjetaController;
use App\Http\Controllers\MaterialesController;
use App\Http\Controllers\ManodeobraController;
use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\AuxiController;
use App\Http\Controllers\CuadrillaController;
use App\Http\Controllers\ExpinsumoController;

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
  return view('welcome');
})->name('welcome');

// Route::get('expinsumos', function () { 
//   return view('tabs/expinsumos'); 
// })->name('expinsumos');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

  require __DIR__.'/auth.php';

  //--------------------------------
  // ---------------rutas de vistas con CRUDS y controller------------
Route::middleware('auth')->group(function () {
  Route::resource('dashboard', DashboardController::class)->name('dashboard.index', 'dashboard');
  Route::resource('tarjetas', TarjetaController::class);
  Route::resource('materiales', MaterialesController::class);
  Route::resource('manodeobra', ManodeobraController::class);
  Route::resource('herramientas', HerramientaController::class); 

  Route::resource('presus', PresuController::class);
  Route::get('/cantEdit/{id}', [PresuController::class, 'edit'])->name('cantEdit');
  Route::post('/updateConceptoCantidad/{id}', [PresuController::class, 'updateConceptoCantidad'])->name('updateConceptoCantidad');
  Route::post('/presus/storeCliente', [PresuController::class, 'storeCliente'])->name('presus.storeCliente');
  Route::delete('/destroyCliente/{cliente}', [PresuController::class, 'destroyClient'])->name('presus.destroyCliente');
  
  Route::resource('auxis', AuxiController::class);
  Route::get('/auxisCopy/{id}',[AuxiController::class, 'copy'])->name('auxisCopy');  
  Route::get('/conceptoDeleteAux/{id}',[AuxiController::class, 'deleteConcepto'])->name('conceptoDeleteAux');
  Route::get('auxis/{auxi}/edit', [AuxiController::class, 'edit'])->name('auxis.edit');
  
  Route::resource('cuadrillas', CuadrillaController::class);
  Route::get('/cuadrillasCopy/{id}',[CuadrillaController::class, 'copy'])->name('cuadrillasCopy');  
  Route::get('/conceptoDeleteCuad/{id}',[CuadrillaController::class, 'deleteConcepto'])->name('conceptoDeleteCuad');
  Route::get('cuadrillas/{cuadrilla}/edit', [CuadrillaController::class, 'edit'])->name('cuadrillas.edit');

  Route::resource('expinsumos', ExpinsumoController::class);  
  Route::get('/expinsumos', [ExpinsumoController::class, 'index'])->name('expinsumos.index');
});


// -----------------ruta para metodo individual------------------
//GET -- visible por URL - para recuperar datos en vista
//POST -- ocultos en el cuerpo - para almacenar datos en la BD




