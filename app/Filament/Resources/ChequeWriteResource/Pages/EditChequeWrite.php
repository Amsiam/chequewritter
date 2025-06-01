<?php

namespace App\Filament\Resources\ChequeWriteResource\Pages;

use App\Filament\Resources\ChequeWriteResource;
use App\Models\Cheque;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditChequeWrite extends EditRecord
{
    protected static string $resource = ChequeWriteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('PDF')
                ->label('Print PDF')
                ->url(fn() => route('cheque-write.pdf', $this->record->id))
                ->icon('heroicon-o-printer')
                ->openUrlInNewTab(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['bank_id'] = Cheque::find($data['cheque_id'])?->bank_id;

        Cheque::where('id', $data['cheque_id'])
            ->where('bank_id', $data['bank_id'])
            ->where('status', 'used')
            ->update(['status' => 'pending']);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = isset($data['user_id']) ? $data['user_id'] : Auth::user()->id;
        Cheque::where('id', $data['cheque_id'])
            ->where('bank_id', $data['bank_id'])
            ->where('status', 'pending')
            ->where('user_id', $data['user_id'])
            ->update(['status' => 'used']);

        unset($data['bank_id']);
        return $data;
    }
}
