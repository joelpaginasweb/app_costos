<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materiales extends Model
{

  use HasFactory;

  protected $table = 'materiales';

  protected $fillable = [
      'id_grupo', 
      'material', 
      'id_unidad', 
      'precio_unitario',
      'id_proveedor'
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

  public function proveedor()
  {
    return $this->belongsTo(Proveedores::class, 'id_proveedor');
  }

}
