<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bosem extends Model
{
    protected $fillable = [
        'nombre_adm',
        'nombre',
        'direccion',
        'tel_lineafija',
        'tel_movil',
        'departamento',
        'distrito',
    ];
}
