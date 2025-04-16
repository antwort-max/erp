<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SysDepartmentResource\Pages;
use App\Filament\Resources\SysDepartmentResource\RelationManagers;
use App\Models\SysDepartment;
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

class SysDepartmentResource extends Resource
{
    protected static ?string $model = SysDepartment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return 'Departamento';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Departamentos';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->label('Department Name')
                ->required()
                ->maxLength(100),
            Textarea::make('description')
                ->label('Description')
                ->rows(3)
                ->maxLength(255),
        ]);
        
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('description')->limit(50)->wrap(),
                TextColumn::make('created_at')->dateTime('d/m/Y'),
                //
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
            'index' => Pages\ListSysDepartments::route('/'),
            'create' => Pages\CreateSysDepartment::route('/create'),
            'edit' => Pages\EditSysDepartment::route('/{record}/edit'),
        ];
    }
}
