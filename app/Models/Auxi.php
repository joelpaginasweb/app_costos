<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Auxi extends Model
{
  use HasFactory;
  protected $table = 'auxiliares';
  protected $fillable = [
    'id_grupo', 
    'material', 
    'id_unidad', 
    'precio_unitario'
  ];


  //Relaciones a otros modelos
  public function grupo()
  {
    return $this->belongsTo(Grupos::class, 'id_grupo');
  }

  public function unidad()
  {
    return $this->belongsTo(Unidades::class, 'id_unidad');
  }

  // public function materialData()
  // {
  //   return $this->belongsTo(Materiales::class, 'id_material');
  // }
  
}
