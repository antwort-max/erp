<?php

namespace App\Filament\Resources\SysPositionResource\Pages;

use App\Filament\Resources\SysPositionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSysPositions extends ListRecords
{
    protected static string $resource = SysPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
