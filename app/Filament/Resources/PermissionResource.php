<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PermissionResource\Pages;
use Spatie\Permission\Models\Permission;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MultiSelect;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationLabel = 'Permisos';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nombre')
                ->required()
                ->unique(Permission::class, 'name', ignoreRecord: true),

            Select::make('guard_name')
                ->label('Guard')
                ->options([
                    'web' => 'Web',
                    'api' => 'API',
                ])
                ->required(),

            MultiSelect::make('roles')
                ->label('Roles')
                ->relationship('roles', 'name')
                ->preload(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('guard_name')
                    ->label('Guard')
                    ->sortable(),

                BadgeColumn::make('roles_count')
                    ->label('Roles')
                    ->counts('roles'),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('guard_name')
                    ->label('Guard')
                    ->options([
                        'web' => 'Web',
                        'api' => 'API',
                    ]),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPermissions::route('/'),
            'create' => Pages\CreatePermission::route('/create'),
            'edit'   => Pages\EditPermission::route('/{record}/edit'),
        ];
    }
}
