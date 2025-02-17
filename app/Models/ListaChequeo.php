<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ambulancia;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ListaChequeo extends Model
{
    use LogsActivity;
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'ambulancia_id',
                'cyrus',
                'fecha',
                'hora',
                'kilometraje',
                'turno',
                'AEM',
                'dui',
                'BOSEM',
                'nivel_combustible',
                'cupones',
                'cantidad_cupones',
                'cupones_inicio',
                'cupones_fin',
                'cantidad_factura',
                'entrega_factura',
                'numeros_factura',
                'detalles_daños',
                'aem_entrega',
                'entrega_firma',
                'aem_recibe',
                'recibe_firma',
                'observaciones',
                'ubicacion',
                'observaciones_fotos',
                'factura_foto',
                'daños_foto',
            ]);
    }
    protected $fillable = [
        'ambulancia_id',
        'cyrus',
        'fecha',
        'hora',
        'kilometraje',
        'turno',
        'AEM',
        'dui',
        'BOSEM',
        'nivel_combustible',
        'cupones',
        'cantidad_cupones',
        'cupones_inicio',
        'cupones_fin',
        'cantidad_factura',
        'entrega_factura',
        'numeros_factura',
        'detalles_daños',
        'aem_entrega',
        'entrega_firma',
        'aem_recibe',
        'recibe_firma',
        'observaciones',
        'ubicacion',
        'observaciones_fotos',
        'factura_foto',
        'daños_foto',
    ];
    protected $casts = [
        'observaciones_fotos' => 'array',
        'factura_foto' => 'array',
        'daños_foto' => 'array',
    ];
    public function herramientas(): HasMany
    {
        return $this->hasMany(Herramientasamb::class);
    }
    public function elementos(): HasMany
    {
        return $this->hasMany(Elementosamb::class);
    }
    public function ambulancia()
    {
        return $this->belongsTo(Ambulancia::class);
    }

}
