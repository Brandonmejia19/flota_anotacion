<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ListaChequeoResource\Pages;
use App\Filament\Resources\ListaChequeoResource\RelationManagers;
use App\Models\Ambulancia;
use App\Models\bosem;
use App\Models\User;
use App\Models\ListaChequeo;
use App\Models\Elementosamb;
use App\Models\Herramientasamb;
use App\Models\Cupon;
use App\Filament\Resources\ListaChequeoResource\RelationManagers\ElementosRelationManager;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Illuminate\Support\Carbon;
use Filament\Forms\Components\Wizard;
use RuelLuna\CanvasPointer\Forms\Components\CanvasPointerField;
use Saade\FilamentAutograph\Forms\Components\SignaturePad;
use App\Forms\Components\combustibleSlider;
use App\Forms\Components\HerramientasListado;
use Illuminate\Support\Facades\Auth;
use Dotswan\MapPicker\Fields\Map;
use Closure;
use Filament\Forms\Components\FileUpload;

class ListaChequeoResource extends Resource
{
    protected static ?string $model = ListaChequeo::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Listas de Chequeo';

    protected static ?string $label = 'Listas de Chequeo';
    public static function form(Form $form): Form
    {
        return $form
            ->schema(components: [
                /*   Wizard::make([
                       Wizard\Step::make('Order')
                           ->schema(components: [*/
                Section::make('LISTA DE CHEQUEO PARA AMBULANCIAS')
                    ->schema([
                        Fieldset::make('Datos Generales')
                            ->schema([
                                Forms\Components\Select::make('ambulancia_id')
                                    ->label('Unidad')
                                    ->required()
                                    ->live(10)
                                    ->reactive()
                                    ->columnSpan(1)
                                    ->options(Ambulancia::all()->pluck('unidad', 'id'))
                                    ->afterStateUpdated(function ($state, $set) {
                                        // $state es el id seleccionado de la ambulancia
                                        $ambulancia = Ambulancia::find($state);
                                        if ($ambulancia) {
                                            // Actualizamos "cyrus" con el valor del registro
                                            $set('cyrus', $ambulancia->cyrus);
                                        }
                                    }),

                                Forms\Components\Select::make('ambulancia_id')
                                    ->label('Placa')
                                    ->required()
                                    ->live()
                                    ->reactive()
                                    ->columnSpan(1)
                                    ->options(Ambulancia::all()->pluck('placa', 'id'))
                                    ->afterStateUpdated(function ($state, $set) {
                                        // $state es el id seleccionado de la ambulancia
                                        $ambulancia = Ambulancia::find($state);
                                        if ($ambulancia) {
                                            // Actualizamos "cyrus" con el valor correspondiente
                                            $set('cyrus', $ambulancia->cyrus);
                                        }
                                    }),

                                Forms\Components\TextInput::make('cyrus')
                                    ->label('Teléfono Cyrus')
                                    ->readonly()
                                    ->required()
                                    ->numeric()
                                    ->live()
                                    ->placeholder('0000-0000')
                                    ->prefix('+503')
                                    ->columnSpan(1)
                                    ->afterStateHydrated(function ($state, $set, $get) {
                                        // Al hidratar, usamos el valor de "ambulancia_id" para obtener "cyrus"
                                        $ambulancia = Ambulancia::find($get('ambulancia_id'));
                                        if ($ambulancia) {
                                            $set('cyrus', $ambulancia->cyrus);
                                        } else {
                                            $set('cyrus', '');
                                        }
                                    }),
                                Forms\Components\TextInput::make('kilometraje')
                                    ->required()
                                    ->numeric()
                                    ->placeholder('0000000')
                                    ->prefix('KM')
                                    ->columnSpan(1),

                                Forms\Components\DatePicker::make('fecha')
                                    ->default(Carbon::now())
                                    ->readonly()
                                    ->prefixicon('heroicon-o-calendar')
                                    ->required(),
                                Forms\Components\TimePicker::make('hora')
                                    ->required()
                                    ->readonly()
                                    ->prefixicon('heroicon-o-clock')
                                    ->default(Carbon::now())
                                    ->native(true),
                                Forms\Components\Select::make('BOSEM')
                                    ->reactive()
                                    ->prefixicon('healthicons-o-emergency-post')
                                    ->label('Base Operativa')
                                    ->required()
                                    ->options(bosem::all()->pluck('nombre', 'nombre'))
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('AEM')
                                    ->required()
                                    ->readonly()
                                    ->default(Auth::user()->name)
                                    ->prefixicon('heroicon-o-user-circle')
                                    ->label('AEM')
                                    ->placeholder('Ingrese nombre de AEM encargado')
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('dui')
                                    ->required()
                                    ->readonly()
                                    ->default(Auth::user()->dui)
                                    ->prefixicon('heroicon-o-user-circle')
                                    ->label('DUI')
                                    ->placeholder('000000-0')
                                    ->columnSpan(1),
                                Forms\Components\ToggleButtons::make('turno')
                                    ->required()
                                    ->inline()
                                    ->options([
                                        '12H' => '12H',
                                        '24H' => '24H'
                                    ])
                                    ->columnSpan(1),
                            ])->columns([
                                    'sm' => 1,//CELULAR
                                    'xl' => 4,//TABLET
                                    '2xl' => 4,//LAPTOP
                                ]),
                    ]),
                // ]),/**1 */
                /*
                  Wizard\Step::make('Order1')/**2 */
                //     ->schema(components: [
                Section::make()
                    ->schema([
                        Fieldset::make('Componentes de Ambulancias')->schema([
                            Forms\Components\Repeater::make(name: 'Listado Elementos')
                                ->defaultItems(count: 1)
                                ->schema([
                                    Forms\Components\Select::make('elemento')
                                        ->required()
                                        ->options(Elementosamb::all()->pluck('nombre', 'nombre'))
                                        ->label('Elemento'),
                                    Forms\Components\ToggleButtons::make('estado')
                                        ->options([
                                            'B' => 'B',
                                            'M' => 'M',
                                        ])
                                        ->label('Estado')
                                        ->inline()
                                        ->required(),
                                    Forms\Components\TextInput::make('observaciones')
                                        ->placeholder('Observaciones')
                                        ->columnSpan(2)
                                        ->label('Observaciones'),
                                ])->columnSpan('full')
                                ->addable(false)
                                ->reorderable(false)
                                ->deletable(false)
                                ->columns(4),

                            Forms\Components\Repeater::make(name: 'Listado Herramientas')
                                ->defaultItems(1)/**Herramientasamb::count() */
                                ->schema([
                                    Forms\Components\Select::make('herramienta')
                                        ->label('')
                                        ->required()
                                        ->options(Herramientasamb::all()->pluck('nombre', 'nombre'))
                                        ->label('Herramienta'),
                                    Forms\Components\ToggleButtons::make('existencia')
                                        ->options([
                                            'SI' => 'SI',
                                            'NO' => 'NO',
                                        ])
                                        ->label('Existencia')
                                        ->inline()
                                        ->required(),
                                    Forms\Components\TextInput::make('observaciones')
                                        ->placeholder('Observaciones')
                                        ->columnSpan(2)
                                        ->label('Observaciones'),
                                ])
                                ->addable(false)
                                ->reorderable(false)
                                ->deletable(false)
                                ->columns(4)
                                ->columnSpan('full'),



                        ]),
                    ]),
                Section::make()
                    ->schema([
                        Fieldset::make(label: 'Nivel de Combustible de la Unidad')->schema([
                            Fieldset::make(label: 'Nivel de Gasolina (%)')->schema([
                                combustibleSlider::make('nivel_combustible')
                                    ->label('')
                                    ->required()
                                    ->columnSpan('full'),
                            ])->columnSpan([
                                        'sm' => 1,//CELULAR
                                        'xl' => 2,//TABLET
                                        '2xl' => 1,//LAPTOP
                                    ]),
                            Forms\Components\Grid::make(4)
                                ->schema([
                                    Forms\Components\ToggleButtons::make('cupones')
                                        ->required()
                                        ->label('Entrega de Cupones')
                                        ->options([
                                            'SI' => 'SI',
                                            'NO' => 'NO',
                                        ])
                                        ->reactive()
                                        ->inline()
                                        ->default('NO')
                                        ->columnSpan(1),
                                    Forms\Components\TextInput::make('cantidad_cupones')
                                        ->required(fn(callable $get): bool => $get('cupones') != 'NO')
                                        ->numeric()
                                        ->disabled(fn(callable $get) => $get('cupones') != 'SI')
                                        ->placeholder('0')
                                        ->step(5)
                                        ->prefixicon('heroicon-o-ticket')
                                        ->columnSpan(1),
                                    Forms\Components\TextInput::make('cupones_inicio')
                                        ->live()
                                        ->required(fn(callable $get) => $get('cupones') != 'NO')
                                        ->disabled(fn(callable $get) => $get('cupones') != 'SI')
                                        ->placeholder('Ingrese números de cupones')
                                        ->prefixicon('heroicon-o-ticket')
                                        ->columnSpan(1),
                                    Forms\Components\TextInput::make('cupones_fin')
                                        ->live()
                                        ->required(fn(callable $get) => $get('cupones') != 'NO')
                                        ->disabled(fn(callable $get) => $get('cupones') != 'SI')
                                        ->prefixicon('heroicon-o-ticket')
                                        ->placeholder('Ingrese números de cupones')
                                        ->columnSpan(1),
                                    Forms\Components\ToggleButtons::make('entrega_factura')
                                        ->label('Entrega de Facturas')
                                        ->options([
                                            'SI' => 'SI',
                                            'NO' => 'NO',
                                        ])
                                        ->inline()
                                        ->reactive()
                                        ->default('NO')
                                        ->required()
                                        ->columnSpan(1),
                                    Forms\Components\TextInput::make('cantidad_factura')
                                        ->disabled(fn(callable $get) => $get('entrega_factura') != 'SI')
                                        ->numeric()
                                        ->live()
                                        ->placeholder('0')
                                        ->step(5)
                                        ->prefixicon('heroicon-o-receipt-percent')
                                        ->columnSpan(1),
                                    Forms\Components\Textarea::make('numeros_factura')
                                        ->live()
                                        ->disabled(condition: fn(callable $get) => $get('entrega_factura') != 'SI')
                                        ->autosize()
                                        ->placeholder('Ingrese números de facturas')
                                        ->columnSpan(2),
                                    Forms\Components\FileUpload::make('factura_foto')
                                        ->image()
                                        ->label('Fotografía de Facturas')
                                        ->deletable()
                                        ->downloadable()
                                        ->previewable()
                                        ->imageeditor()
                                        ->columnSpan('full'),
                                ])->columnSpan([
                                        'sm' => 3,//CELULAR
                                        'xl' => 4,//TABLET
                                        '2xl' => 2,//LAPTOP
                                    ]),
                        ])->columns([
                                    'sm' => 3,//CELULAR
                                    'xl' => 3,//TABLET
                                    '2xl' => 3,//LAPTOP
                                ]),
                        Fieldset::make('Detalles de Daños de Ambulancia')->schema([
                            CanvasPointerField::make('detalles_daños')
                                ->pointRadius(5) // default is 5
                                ->imageUrl('https://as2.ftcdn.net/v2/jpg/05/34/55/69/1000_F_534556959_RBCrmGpcmxDajQ6Y67iVtwjc5GOtSMRI.jpg') // required
                                ->width(500) // required
                                ->height(300) // required
                                ->columnSpan(2),
                            Forms\Components\FileUpload::make('daños_foto')
                                ->image()
                                ->deletable()
                                ->downloadable()
                                ->previewable()
                                ->imageeditor()
                                ->columnSpan(2),
                            Forms\Components\TextInput::make('aem_entrega')
                                ->required()
                                ->default(Auth::user()->name)
                                ->readonly()
                                ->placeholder('Ingrese nombre de AEM encargado')
                                ->prefixicon('heroicon-o-user')
                                ->columnSpan(2),
                            Forms\Components\Select::make('aem_recibe')
                                ->required()
                                ->searchable()
                                ->options(options: User::all()->pluck('name', 'name'))
                                ->placeholder('Ingrese nombre de AEM encargado')
                                ->prefixicon('heroicon-o-user')
                                ->columnSpan(2),
                            SignaturePad::make('entrega_firma')
                                ->required()
                                ->label(__('Firma de Entrega'))
                                ->dotSize(2.0)
                                ->lineMinWidth(0.5)
                                ->lineMaxWidth(2.5)
                                ->throttle(16)
                                ->minDistance(1)
                                ->downloadable(false)
                                ->undoable(false)->confirmable()
                                ->confirmable(false)
                                ->velocityFilterWeight(0.5)
                                ->columnSpan(2),
                            SignaturePad::make('recibe_firma')
                                ->label(__('Firma de Recibe'))
                                ->dotSize(1.5)
                                ->required()
                                ->lineMinWidth(0.5)->required()
                                ->lineMaxWidth(2.5)
                                ->throttle(16)
                                ->minDistance(5)->confirmable()
                                ->downloadable(false)
                                ->undoable(false)
                                ->confirmable(false)
                                ->velocityFilterWeight(0.7)
                                ->columnSpan(2),
                            Forms\Components\Textarea::make('observaciones')
                                ->placeholder('Observaciones')
                                ->columnSpan(3),
                            Forms\Components\FileUpload::make('observaciones_fotos')
                                ->image()
                                ->deletable()
                                ->disk('public')
                                ->live()
                                ->openable()
                                ->downloadable()
                                ->storeFiles(true)
                                ->previewable(true)
                                ->imageeditor()
                                ->columnSpan(span: 1),
                            Map::make('ubicacion')
                                ->label('Ubicación actual')
                                ->disabled() // Deshabilita la modificación por el usuario
                                ->required()
                                ->geoman()
                                ->label('Ubicación Actual')
                                ->columnSpanFull()
                                ->liveLocation(true, true, 1000)
                            // Basic Configuration
                        ])->columns(4),
                    ])->columns(2),
            ]);/**3 +*/
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('N#')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ambulancia.unidad')
                    ->label('Unidad')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ambulancia.placa')
                    ->searchable()
                    ->label('Placa')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kilometraje')
                    ->prefix('KM ')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('AEM')
                    ->label('AEM entrega')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('aem_recibe')
                    ->label('AEM Recibe')
                    ->searchable()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('nivel_combustible')
                    ->label('AEM Recibe')
                    ->prefix('% ')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha')
                    ->searchable()
                    ->date()
                    ->sortable(),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

            ]);
    }

    public static function getRelations(): array
    {
        return [
            //  ElementosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListListaChequeos::route('/'),
            'create' => Pages\CreateListaChequeo::route('/create'),
            'edit' => Pages\EditListaChequeo::route('/{record}/edit'),
        ];
    }
}
