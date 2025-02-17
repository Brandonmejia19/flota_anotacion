<?php

namespace App\Filament\Resources\ListaChequeoResource\Pages;

use App\Filament\Resources\ListaChequeoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\ExportAction;
use App\Filament\Exports\ListaChequeoExporter;
use Filament\Actions\Exports\Models\Export;

class ListListaChequeos extends ListRecords
{
    protected static string $resource = ListaChequeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->createAnother(false),
            ExportAction::make()
                ->exporter(ListaChequeoExporter::class)->label('Descargar Excel')
                ->color('orange')
                ->fileName(fn(Export $export): string => "inventarios-{$export->getKey()}")
        ];
    }
}
