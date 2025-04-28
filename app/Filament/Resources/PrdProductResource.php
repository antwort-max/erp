<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrdProductResource\Pages;
use App\Models\PrdProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PrdProductResource extends Resource
{
    protected static ?string $model = PrdProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Productos';
    protected static ?string $modelLabel = 'Producto';
    protected static ?string $pluralModelLabel = 'Productos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Producto')->tabs([
                    Forms\Components\Tabs\Tab::make('Información básica')->schema([
                        Forms\Components\TextInput::make('sku')->required()->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                        Forms\Components\Select::make('category_id')->relationship('category', 'name')->required(),
                        Forms\Components\Select::make('family_id')->relationship('family', 'name')->required(),
                        Forms\Components\Select::make('subfamily_id')->relationship('subfamily', 'name')->required(),
                        Forms\Components\Select::make('brand_id')->relationship('brand', 'name')->required(),
                        Forms\Components\Textarea::make('description')->rows(3),
                        Forms\Components\FileUpload::make('image')->image()->directory('products'),
                        Forms\Components\Toggle::make('status')->label('Activo'),
                    ]),
                    Forms\Components\Tabs\Tab::make('Precios y unidades')->schema([
                        Forms\Components\TextInput::make('unit')->label('Unidad base')->required(),
                        Forms\Components\TextInput::make('unit_price')->numeric()->prefix('$')->required(),
                        Forms\Components\TextInput::make('package_unit')->label('Unidad de paquete')->required(),
                        Forms\Components\TextInput::make('package_qty')->numeric()->label('Cantidad por paquete')->required(),
                        Forms\Components\TextInput::make('package_price')->numeric()->prefix('$')->required(),
                        Forms\Components\TextInput::make('cost')->numeric()->prefix('$')->label('Costo')->nullable(),
                    ]),
                    Forms\Components\Tabs\Tab::make('Stock y logística')->schema([
                        Forms\Components\TextInput::make('stock')->numeric()->default(0),
                        Forms\Components\TextInput::make('weight')->numeric()->suffix('kg')->nullable(),
                        Forms\Components\TextInput::make('dimensions')->placeholder('Ej: 10x5x3 cm')->nullable(),
                    ]),
                    Forms\Components\Tabs\Tab::make('SEO y Marketing')->schema([
                        Forms\Components\TextInput::make('meta_title')->maxLength(60),
                        Forms\Components\Textarea::make('meta_description')->rows(2)->maxLength(160),
                        Forms\Components\TextInput::make('meta_keywords')->helperText('Palabras clave separadas por coma'),
                        Forms\Components\TextInput::make('tags')->label('Etiquetas'),
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sku')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('name')->searchable()->sortable()->limit(40),
                Tables\Columns\TextColumn::make('unit_price')->money('CLP')->sortable(),
                Tables\Columns\TextColumn::make('stock')->sortable(),
                Tables\Columns\ToggleColumn::make('status')->label('Activo'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('d/m/Y H:i')->label('Actualizado'),
            ])
            ->filters([
                // Agrega filtros si quieres más adelante
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPrdProducts::route('/'),
            'create' => Pages\CreatePrdProduct::route('/create'),
            'edit'   => Pages\EditPrdProduct::route('/{record}/edit'),
        ];
    }
}
