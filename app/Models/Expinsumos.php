<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expinsumos extends Model
{
    use HasFactory;
    protected $table = 'exp_insumos';
    protected $fillable = [
      'id_grupo',
      'id_presup',
      // 'id_tarjeta',
      'id_material',
      'id_categoria',
      'id_equipo',
      'cantidad', 
      'monto'
    ];

    //Relaciones a otros modelos
    public function grupo()
    {
      return $this->belongsTo(Grupos::class, 'id_grupo');
    }
    
    public function presup()
    {
      return $this->belongsTo(Presu::class, 'id_presup');
    }

    public function material()
    {
      return $this->belongsTo(Materiales::class, 'id_material');
    }

    public function categoria()
    {
      return $this->belongsTo(Manodeobra::class, 'id_categoria');
    }

    public function equipo()
    {
      return $this->belongsTo(Herramienta::class, 'id_equipo');
    }

  
}
