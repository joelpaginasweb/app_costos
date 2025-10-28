<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Porcent extends Model
{
    use HasFactory;
    protected $table = 'porcent_indirectos';
    protected $fillable = [
      'id_presup',
      // 'id_tarjeta',
      'porcent_indirecto',
      'porcent_financiam',
      'porcent_utilidad',
      'porcent_costos_add',
      'porcent_suma'
    ];
}
