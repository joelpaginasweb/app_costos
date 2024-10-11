<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Auxi extends Model
{
  use HasFactory;
  protected $table = 'auxis';
  protected $fillable = ['grupo', 'material', 'unidad', 'precio_unitario'];
  
}
