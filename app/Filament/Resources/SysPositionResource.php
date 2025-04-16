<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SysPositionResource\Pages;
use App\Filament\Resources\SysPositionResource\RelationManagers;
use App\Models\SysPosition;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class SysPositionResource extends Resource
{
    protected static ?string $model = SysPosition::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return 'Posición';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Posiciones';
    }
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Position Name')
                    ->required()
                    ->maxLength(100),
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->maxLength(255),//
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('description')->limit(50)->wrap(),
                TextColumn::make('created_at')->dateTime('d/m/Y'),//
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListSysPositions::route('/'),
            'create' => Pages\CreateSysPosition::route('/create'),
            'edit' => Pages\EditSysPosition::route('/{record}/edit'),
        ];
    }
}
