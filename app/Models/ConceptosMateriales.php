<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptosMateriales extends Model
{
    use HasFactory;
    protected $table ='conceptos_materiales';
    protected $fillable = [
      'id_material',
      'id_tarjeta',
      'cantidad', 
      'importe'
    ];

    public function material()
    {
      return $this->belongsTo(Materiales::class, 'id_material');
    }

}
