<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ambulancia extends Model
{
    protected $fillable = [
        'placa',
        'unidad',
        'kilometraje',
        'cyrus',
        'estado_ambulancia',
        'camaras',
        'radio',
    ];
    public function listaChequeo():HasMany
    {
        return $this->hasMany(ListaChequeo::class);
    }
}
