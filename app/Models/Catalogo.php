<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    use HasFactory;
    protected $table = 'catalogo_conceptos';
    protected $fillable = [
      'concepto',
     'unidad', 
     'cantidad', 
     'precio_unitario', 
     'importe', 
     'id_tarjeta',
      'id_presup',
      'costo_directo',
      'costo_indirecto',
      'indirectos',
      'financiam',
      'utilidad',
      'cargos_adicion'    
    ];
    // protected $casts = [ 'importe' => 'decimal:2', 'cantidad' => 'decimal:2' ]; // para que los datos se pasen con decimales 
}
