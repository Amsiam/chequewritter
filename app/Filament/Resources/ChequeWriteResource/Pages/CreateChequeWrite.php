<?php

namespace App\Filament\Resources\ChequeWriteResource\Pages;

use App\Filament\Resources\ChequeWriteResource;
use App\Models\Cheque;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateChequeWrite extends CreateRecord
{
    protected static string $resource = ChequeWriteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $data["user_id"] = isset($data['user_id']) ? $data['user_id'] : Auth::user()->id;


        Cheque::where('id', $data['cheque_id'])
            ->where('bank_id', $data['bank_id'])
            ->where('status', 'pending')
            ->where('user_id', $data['user_id'])
            ->update(['status' => 'used']);


        unset($data['bank_id']);

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return route('cheque-write.pdf', $this->getRecord()->id);
    }
}
