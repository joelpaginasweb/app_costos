<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MaterialesController;
use App\Http\Controllers\ManodeobraController;
use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\PresuController;
use App\Http\Controllers\TarjetaController;
use App\Http\Controllers\DashboController;
use App\Http\Controllers\AuxiController;


// Route::get('/', function () {
//     return view('welcome');
// });

//---------rutas de vistas provisionales sin controller-------------
Route::get('/', function () { // vista inicio landing page
  return view('inicio'); 
})->name('landing');

//---------------rutas de vistas con CRUDS y controller------------
Route::resource('dashbos', DashboController::class);
Route::resource('presus', PresuController::class);
Route::resource('tarjetas', TarjetaController::class);
Route::resource('materiales', MaterialesController::class);
Route::resource('manodeobra', ManodeobraController::class);
Route::resource('herramientas', HerramientaController::class);
Route::resource('auxis', AuxiController::class);

// -----------------ruta para metodo individual------------------
//GET -- visible por URL - para recuperar datos en vista
//POST -- ocultos en el cuerpo - para almacenar datos en la BD

Route::get('/editPresupuesto/{id}', [PresuController::class, 'edit'])->name('editPresupuesto');

Route::post('/calcularConceptos/{id}', [PresuController::class, 'calcularConceptos'])->name('calcularConceptos');
// Route::post('/calcularConceptos', [PresuController::class, 'calcularConceptos'])->name('calcular.conceptos'); 

Route::post('/updateConceptoCantidad/{id}', [PresuController::class, 'updateConceptoCantidad'])->name('updateConceptoCantidad');



