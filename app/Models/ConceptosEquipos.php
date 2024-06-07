<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptosEquipos extends Model
{
    use HasFactory;
    protected $table = 'conceptos_equipos';
    protected $fillable = ['id_equipo','concepto', 'unidad', 'cantidad', 'precio_unitario', 'importe',  'id_tarjeta'];

}

