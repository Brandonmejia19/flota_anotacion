<?php

namespace App\Filament\Exports;

use App\Models\ListaChequeo;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ListaChequeoExporter extends Exporter
{
    protected static ?string $model = ListaChequeo::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('ambulancia_id'),
            ExportColumn::make('fecha'),
            ExportColumn::make('turno'),
            ExportColumn::make('AEM'),
            ExportColumn::make('nivel_combustible'),
            ExportColumn::make('cupones'),
            ExportColumn::make('cantidad_cupones'),
            ExportColumn::make('entrega_factura'),
            ExportColumn::make('cantidad_factura'),
            ExportColumn::make('numeros_factura'),
            ExportColumn::make('detalles_daños'),
            ExportColumn::make('aem_entrega'),
            ExportColumn::make('entrega_firma'),
            ExportColumn::make('aem_recibe'),
            ExportColumn::make('recibe_firma'),
            ExportColumn::make('observaciones'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
            ExportColumn::make('kilometraje'),
            ExportColumn::make('hora'),
            ExportColumn::make('BOSEM'),
            ExportColumn::make('uuid')
                ->label('UUID'),
            ExportColumn::make('cupones_inicio'),
            ExportColumn::make('cupones_fin'),
            ExportColumn::make('cyrus'),
            ExportColumn::make('dui'),
            ExportColumn::make('ubicacion'),
            ExportColumn::make('factura_foto'),
            ExportColumn::make('daños_foto'),
            ExportColumn::make('observaciones_fotos'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your lista chequeo export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
