<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptosAuxiliares extends Model
{
  use HasFactory;
  protected $table = 'conceptos_auxiliares';

  protected $fillable = [
    'id_material', 
    'id_auxiliar', 
    'cantidad', 
    'importe'
  ];

  public function materialData()
  {
    return $this->belongsTo(Materiales::class, 'id_material');
  }

  public function unidad()
  {
    return $this->belongsTo(Unidades::class, 'id_unidad');
  }       


}
