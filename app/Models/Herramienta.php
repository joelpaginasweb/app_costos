<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    use HasFactory;
    protected $table = 'herramientas_equipos';

    protected $fillable = [
      'id_grupo',
      'herramienta_equipo',
      'precio_unitario',
      'id_marca',
      'id_proveedor',
      'id_unidad',
    ];

    //Relaciones a otros modelos
    public function grupo()
    {
      return $this->belongsTo(Grupos::class, 'id_grupo');
    }
    
    public function marca()
    {
      return $this->belongsTo(Marcas::class, 'id_marca');
    }

    public function proveedor()
    {
      return $this->belongsTo(Proveedores::class, 'id_proveedor');
    }

    public function unidad()
    {
      return $this->belongsTo(Unidades::class, 'id_unidad');
    }

}
