<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptosManoObras extends Model
{
    use HasFactory;
    protected $table = 'conceptos_mano_obras';
    protected $fillable = ['id_mano_obra',  'concepto', 'unidad', 'cantidad', 'precio_unitario', 'importe',  'id_tarjeta'];

}
