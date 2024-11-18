<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptosManoObras extends Model
{
    use HasFactory;
    protected $table = 'conceptos_mano_obras';
    protected $fillable = [
      'id_categoria',
      'id_cuadrilla',
      'id_tarjeta',
      'cantidad', 
      'importe'
    ];

    public function categoria()
    {
      return $this->belongsTo(Manodeobra::class, 'id_categoria');
    }

}
