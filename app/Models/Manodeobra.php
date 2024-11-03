<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Manodeobra extends Model
{
  use HasFactory;
  protected $table = 'mano_de_obra';
  protected $fillable = [
    'id_grupo', 
    'categoria',
    'id_unidad', 
    'salario_base', 
    'factor_sr', 
    'salario_real'
  ];

  //Relaciones a otros modelos
  public function grupox()
  {
    return $this->belongsTo(Grupos::class, 'id_grupo');
  }

  public function unidad()
  {
    return $this->belongsTo(Unidades::class, 'id_unidad');
  }


     // public function metodo/parametro()
    // {
    //   return $this->belongsTo(Modelo::class, 'id_claveForanea');
    // }


         

}



