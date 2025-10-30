<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    use HasFactory;
    protected $table = 'tarjetas';
    
    protected $fillable = [      
      'id_grupo',
      'concepto', 
      'id_unidad', 
      'id_presup',
      'costo_material',
      'costo_mano_obra',
      'costo_equipo',
      'costo_directo',
      'indirectos',
      'financiam',
      'utilidad',
      'cargos_adicion',      
      'costo_indirecto',
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

    public function presupuesto()
    {
      return $this->belongsTo(Presu::class, 'id_presup');
    }

    // public function porcent()
    // {
    //   return $this->hasOne(Porcent::class, 'id_tarjeta');
    // }

}


