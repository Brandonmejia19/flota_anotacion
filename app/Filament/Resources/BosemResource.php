<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BosemResource\Pages;
use App\Filament\Resources\BosemResource\RelationManagers;
use App\Models\Bosem;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BosemResource extends Resource
{
    protected static ?string $model = Bosem::class;
    protected static ?string $label = 'Bases Operativa';
    protected static ?string $navigationLabel = 'Bases Operativas';

    protected static ?string $navigationGroup = 'Desplegable';
    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\TextInput::make('nombre')
                        ->prefixIcon('heroicon-o-document-text')
                        ->placeholder('Ingrese el nombre perteneciente a Base Operativa')
                        ->required()
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('nombre_adm')
                        ->label('Nombre del Administrador')
                        ->prefixIcon('heroicon-o-user')
                        ->placeholder('Ingrese el nombre del administrador de Base Operativa')
                        ->required()
                        ->columnSpan(1),
                    Forms\Components\TextInput::make('tel_lineafija')
                        ->placeholder('####-####')
                        ->label('Teléfono Fijo')
                        ->prefixIcon('heroicon-o-phone')
                        ->tel(8)
                        ->columnSpan(1)
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('tel_movil')
                        ->placeholder('####-####')
                        ->label('Teléfono Móvil')
                        ->prefixIcon('heroicon-o-phone')
                        ->tel(8)
                        ->columnSpan(1)
                        ->required()
                        ->numeric(),
                    Forms\Components\Select::make('departamento')
                        ->placeholder('Seleccione el departamento')
                        ->options([
                            'Ahuachapán' => 'Ahuachapán',
                            'Cabañas' => 'Cabañas',
                            'Chalatenango' => 'Chalatenango',
                            'Cuscatlán' => 'Cuscatlán',
                            'La Libertad' => 'La Libertad',
                            'La Paz' => 'La Paz',
                            'La Unión' => 'La Unión',
                            'Morazán' => 'Morazán',
                            'San Miguel' => 'San Miguel',
                            'San Salvador' => 'San Salvador',
                            'San Vicente' => 'San Vicente',
                            'Santa Ana' => 'Santa Ana',
                            'Sonsonate' => 'Sonsonate',
                            'Usulután' => 'Usulután',
                        ])
                        ->prefixIcon('heroicon-o-map-pin')
                        ->required()
                        ->columnSpan(1)
                        ->label('Departamento'),
                    Forms\Components\Select::make('distrito')
                        ->placeholder('Seleccione el distrito')
                        ->prefixIcon('heroicon-o-map-pin')
                        ->options([
                            'Distrito 1' => 'Distrito 1',
                            'Distrito 2' => 'Distrito 2',
                            'Distrito 3' => 'Distrito 3',
                            'Distrito 4' => 'Distrito 4',
                            'Distrito 5' => 'Distrito 5'
                        ])
                        ->required()
                        ->columnSpan(1)
                        ->label('Distrito'),
                    Forms\Components\Textarea::make('direccion')
                        ->required()
                        ->placeholder(placeholder: 'Ingrese la dirección perteneciente a Base Operativa')
                        ->columnSpanFull(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tel_lineafija')
                    ->label('Teléfono Fijo')
                    ->prefix('(+503) ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tel_movil')
                    ->label('Teléfono Movil')
                    ->prefix('(+503) ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('direccion')
                    ->sortable(),
                Tables\Columns\TextColumn::make('departamento')
                    ->sortable()
                    ->label('Departamento'),
                Tables\Columns\TextColumn::make('distrito')
                    ->sortable()
                    ->label('Distrito'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBosems::route('/'),
            'create' => Pages\CreateBosem::route('/create'),
            'edit' => Pages\EditBosem::route('/{record}/edit'),
        ];
    }
}
