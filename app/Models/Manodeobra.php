<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Manodeobra extends Model
{
  use HasFactory;
  protected $table = 'manodeobra';
  protected $fillable = ['grupo', 'categoria','unidad', 'salario_base', 'factor_sr', 'salario_real'];
    
}



