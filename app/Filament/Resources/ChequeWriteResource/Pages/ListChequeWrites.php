<?php

namespace App\Filament\Resources\ChequeWriteResource\Pages;

use App\Filament\Resources\ChequeWriteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChequeWrites extends ListRecords
{
    protected static string $resource = ChequeWriteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
