<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    
    protected static ?string $label = 'Usuario';
    protected static ?string $pluralLabel = 'Usuarios';
    protected static ?string $navigationGroup = 'Administración';
    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Tabs::make('User Details')
                ->columnSpan('full')      // Ocupa todo el ancho disponible      // Etiquetas en el costado para más ancho al contenido
                ->tabs([
                    Tabs\Tab::make('Identification')->schema([
                        TextInput::make('dni')
                            ->label('DNI')
                            ->required()
                            ->unique(User::class, 'dni', ignoreRecord: true),
                        TextInput::make('code')
                            ->label('Code')
                            ->required()
                            ->unique(User::class, 'code', ignoreRecord: true),
                    ]),
                    Tabs\Tab::make('Credentials')->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(User::class, 'email', ignoreRecord: true),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                            ->same('passwordConfirmation')
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                        TextInput::make('passwordConfirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser),
                    ]),
                    Tabs\Tab::make('Personal')->schema([
                        DatePicker::make('date_of_birth')
                            ->label('Date of Birth'),
                        Select::make('gender')
                            ->label('Gender')
                            ->options([
                                'M' => 'Masculino',
                                'F' => 'Femenino',
                                'O' => 'Otro',
                            ]),
                        FileUpload::make('avatar_path')
                            ->label('Avatar')
                            ->image(),
                    ]),
                    Tabs\Tab::make('Contact')->schema([
                        TextInput::make('phone')
                            ->label('Phone'),
                        TextInput::make('whatsapp')
                            ->label('WhatsApp'),
                        TextInput::make('address')
                            ->label('Address'),
                    ]),
                    Tabs\Tab::make('Relations')->schema([
                        Select::make('position_id')
                            ->label('Position')
                            ->relationship('position', 'name')
                            ->preload(),
                        Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'name')
                            ->preload(),
                        Select::make('role_id')
                            ->label('Role')
                            ->relationship('role', 'name')
                            ->preload(),
                    ]),
                    Tabs\Tab::make('Commercial')->schema([
                        TextInput::make('supplier_company_name')
                            ->label('Supplier Company'),
                        TextInput::make('supplier_commercial_email')
                            ->label('Supplier Email')
                            ->email(),
                        Textarea::make('supplier_commercial_info')
                            ->label('Supplier Info'),
                    ]),
                    Tabs\Tab::make('Metadata')->schema([
                        Textarea::make('metadata')
                            ->label('Metadata (JSON)')
                            ->json(),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
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
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
