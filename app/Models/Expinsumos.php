<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expinsumos extends Model
{
    use HasFactory;
    protected $table = 'exp_insumos';
    protected $fillable = ['tipo', 'insumo', 'unidad', 'cantidad', 'precio_unitario', 'monto', 'id_presup'];
}
