<?php

namespace App\Filament\Resources\SysDepartmentResource\Pages;

use App\Filament\Resources\SysDepartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSysDepartment extends EditRecord
{
    protected static string $resource = SysDepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
