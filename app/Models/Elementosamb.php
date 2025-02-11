<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elementosamb extends Model
{
    protected $fillable = [
        'nombre',

    ];
    public function listaChequeo()
    {
        return $this->belongsTo(ListaChequeo::class);
    }
}
