<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Concerns\HasObservers; //para observar cambios en tabla de bd
// use App\Observers\MaterialesObserver; ////para observar cambios en tabla de bd


class Materiales extends Model
{

  use HasFactory;
  protected $fillable = ['grupo', 'material', 'unidad', 'precio_unitario', 'proveedor'];  


  //para observar cambios en tabla de bd
  // protected static function boot()
  // {
  //     parent::boot();

  //     static::observe(MaterialesObserver::class);
  // }
  // use HasObservers;



}
