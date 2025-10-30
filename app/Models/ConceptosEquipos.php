<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptosEquipos extends Model
{
    use HasFactory;
    protected $table = 'conceptos_equipos';
    protected $fillable = [
      'id_equipo',
      'id_tarjeta',
      'cantidad',
      'importe'
    ];

    public function equipo()
    {
      return $this->belongsTo(Herramienta::class, 'id_equipo');
    }

}

