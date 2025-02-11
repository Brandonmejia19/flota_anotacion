<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class ListaChequeo extends Model
{
    protected $fillable = [
        'fecha',
        'hora',
        'kilometraje',
        'turno',
        'AEM',
        'BOSEM',
        'nivel_combustible',
        'cupones',
        'cantidad_cupones',
        'cupones_inicio',
        'cupones_fin',
        'cantidad_factura',
        'numeros_factura',
        'detalles_daños',
        'aem_entrega',
        'entrega_firma',
        'aem_recibe',
        'recibe_firma',
        'observaciones'
    ];
    public function herramientas(): HasMany
    {
        return $this->hasMany(Herramientasamb::class);
    }
    public function elementos(): HasMany
    {
        return $this->hasMany(Elementosamb::class);
    }

}
