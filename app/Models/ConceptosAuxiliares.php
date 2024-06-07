<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptosAuxiliares extends Model
{
    use HasFactory;
    protected $table = 'conceptos_auxiliares';
    protected $fillable = ['concepto', 'unidad', 'cantidad', 'precio_unitario', 'importe',  'id_material', 'id_auxiliar'];
}
