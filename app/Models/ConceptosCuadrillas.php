<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptosCuadrillas extends Model
{
    use HasFactory;
    protected $table = 'conceptos_cuadrillas';
    protected $fillable = ['id_categoria', 'categoria', 'unidad', 'cantidad', 'salario', 'importe',  'id_cuadrilla'];
}
