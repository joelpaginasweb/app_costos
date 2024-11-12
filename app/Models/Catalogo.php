<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    use HasFactory;
    protected $table = 'catalogo_conceptos';
    protected $fillable = [
      'id_tarjeta',
      'id_presup',
      'cantidad', 
      'importe', 
      'costo_directo',
      'costo_indirecto',
      'indirectos',
      'financiam',
      'utilidad',
      'cargos_adicion'    
    ];

      //Relaciones a otros modelos
  public function concepto()
  {
    return $this->belongsTo(Tarjeta::class, 'id_tarjeta');
  }




    
}
