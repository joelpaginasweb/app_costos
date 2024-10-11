<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuadrillas extends Model
{
    use HasFactory;
  protected $table = 'cuadrillas';
  protected $fillable = ['grupo', 'descripcion', 'unidad', 'total'];

}
