<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $table = 'clientes';

    protected $fillable = [
      'nombre',
      'calle', 
      'no_exterior',
      'cp',
      'colonia', 
      'id_ciudad', 
      'id_estado'
    ];

    //Relaciones a otros modelos
    public function ciudad()
    {
      return $this->belongsTo(Ciudades::class, 'id_ciudad');
    }

    public function estado()
    {
      return $this->belongsTo(Estados::class, 'id_estado');
    }

}
