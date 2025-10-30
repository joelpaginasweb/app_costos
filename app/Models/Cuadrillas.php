<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuadrillas extends Model
{
    use HasFactory;
  protected $table = 'cuadrillas';
  protected $fillable = [
    'id_grupo',
    'descripcion',
    'id_unidad', 
    'total'
    ];

    //Relaciones a otros modelos
    public function grupo()
    {
      return $this->belongsTo(Grupos::class, 'id_grupo');
    }
  
    public function unidad()
    {
      return $this->belongsTo(Unidades::class, 'id_unidad');
    }

}
