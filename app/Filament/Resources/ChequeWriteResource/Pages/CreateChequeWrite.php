<?php

namespace App\Filament\Resources\ChequeWriteResource\Pages;

use App\Filament\Resources\ChequeWriteResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateChequeWrite extends CreateRecord
{
    protected static string $resource = ChequeWriteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['bank_id']);

        $data["user_id"] = isset($data['user_id']) ? $data['user_id'] : auth()->user()->id;

        return $data;
    }
}
