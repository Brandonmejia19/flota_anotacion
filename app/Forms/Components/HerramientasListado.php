<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class HerramientasListado extends Field
{
    protected string $view = 'forms.components.herramientas-listado';
    protected function setUp(): void
    {
        parent::setUp();

        // Si se requiere que el campo siempre tenga un array con una entrada por cada herramienta:
        $this->default(function () {
            return \App\Models\Herramientasamb::all()->map(function ($herramienta) {
                return [
                    'herramienta'   => $herramienta->nombre, // o $herramienta->id si prefieres trabajar con IDs
                    'existencia'    => null,
                    'observaciones' => null,
                ];
            })->toArray();
        });
    }
}
