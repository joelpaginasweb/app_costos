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

// ---------------rutas de vistas con CRUDS y controller------------
Route::middleware('auth')->group(function () {
  Route::resource('dashboard', DashboardController::class)->name('dashboard.index', 'dashboard');

  Route::resource('manodeobra', ManodeobraController::class);
  Route::get('/manodeobraCopy/{id}',[ManodeobraController::class, 'copy'])->name('manodeobraCopy');  

  Route::resource('herramientas', HerramientaController::class); 
  Route::get('/herramientasCopy/{id}',[HerramientaController::class, 'copy'])->name('herramientasCopy');  

  Route::resource('materiales', MaterialesController::class);
  Route::get('/materialCopy/{id}',[MaterialesController::class, 'copy'])->name('materialCopy');  

  Route::resource('presus', PresuController::class);
  Route::get('/cantEdit/{id}', [PresuController::class, 'edit'])->name('cantEdit');
  Route::post('/updateConceptoCantidad/{id}', [PresuController::class, 'updateConceptoCantidad'])->name('updateConceptoCantidad');
  Route::post('/presus/storeCliente', [PresuController::class, 'storeCliente'])->name('presus.storeCliente');
  Route::delete('/destroyCliente/{cliente}', [PresuController::class, 'destroyClient'])->name('presus.destroyCliente');
  Route::get('/presusCopy/{id}',[PresuController::class, 'copy'])->name('presusCopy');
  
  Route::resource('auxis', AuxiController::class);
  Route::get('/auxisCopy/{id}',[AuxiController::class, 'copy'])->name('auxisCopy');

  Route::get('/conceptoDeleteAux/{id}',[AuxiController::class, 'deleteConcepto'])->name('conceptoDeleteAux');

  Route::resource('tarjetas', TarjetaController::class);
  Route::get('/tarjetasCopy/{id}',[TarjetaController::class, 'copy'])->name('tarjetasCopy');  
  Route::get('/conceptoDeleteTarj/{id}/{type?}', [TarjetaController::class, 'deleteConcepto'])->name('conceptoDeleteTarj');

  
  Route::resource('cuadrillas', CuadrillaController::class);
  Route::get('/cuadrillasCopy/{id}',[CuadrillaController::class, 'copy'])->name('cuadrillasCopy');  
  Route::get('/conceptoDeleteCuad/{id}',[CuadrillaController::class, 'deleteConcepto'])->name('conceptoDeleteCuad');

  Route::resource('expinsumos', ExpinsumoController::class);  

});

// -----------------ruta para metodo individual------------------
//GET -- visible por URL - para recuperar datos en vista
//POST -- ocultos en el cuerpo - para almacenar datos en la BD




