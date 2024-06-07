<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presu extends Model
{
    use HasFactory;
    protected $table = 'presus';
    protected $fillable = [
      'obra', 
      'cliente',
      'direccion',
      'colonia',
      'municipio', 
      'estado', 
      'estatus',
      'costo_directo',
      'costo_indirecto',
      'costo_total',      
      'porcent_indirecto',
      'porcent_financiam',
      'porcent_utilidad',
      'porcent_costos_add',
      'porcent_suma',
      'indirectos',
      'financiam',
      'utilidad',
      'cargos_adicion'
    ];


}
