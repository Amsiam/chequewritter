<?php

namespace App\Filament\Resources\ChequeWriteResource\Pages;

use App\Filament\Resources\ChequeWriteResource;
use App\Models\Cheque;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

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
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['bank_id']);
        return $data;
    }
}
