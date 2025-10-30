<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptosCuadrillas extends Model
{
    use HasFactory;
    protected $table = 'conceptos_cuadrillas';
    protected $fillable = [
      'id_categoria',
      'id_cuadrilla',       
      'cantidad',          
      'importe'             
    ];

    public function categoriaData()
  {
    return $this->belongsTo(Manodeobra::class, 'id_categoria');
  }

  public function unidad()
  {
    return $this->belongsTo(Unidades::class, 'id_unidad');
  }  
}
