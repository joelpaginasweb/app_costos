<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model
{
    use HasFactory;
    protected $table = 'ciudades';
    protected $fillable = [ 'ciudad', 'id_estado' ];

    //Relaciones a otros modelos
    public function estado()
    {
      return $this->belongsTo(Estados::class, 'id_estado');
    }
    
}
