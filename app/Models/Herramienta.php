<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    use HasFactory;
    protected $fillable = ['grupo', 'equipo', 'modelo', 'marca', 'proveedor', 'unidad', 'precio_unitario'];
}
