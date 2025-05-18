<?php

namespace App\Filament\Resources\ChequeResource\Pages;

use App\Filament\Resources\ChequeResource;
use App\Models\Cheque;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCheques extends ManageRecords
{
    protected static string $resource = ChequeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add Cheque')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->mutateFormDataUsing(
                    function (array $data): array {
                        $array = [];

                        for ($i = $data['cheque_number_start']; $i <= $data['cheque_number_end']; $i++) {
                            $array[] = [
                                'bank_id' => $data['bank_id'],
                                'cheque_number' => $i,
                                'user_id' => isset($data['user_id']) ? $data['user_id'] : auth()->user()->id,
                                'status' => 'pending',
                            ];
                        }
                        return $array;
                    }
                )->action(
                    function (array $data): void {
                        foreach ($data as $cheque) {
                            Cheque::create($cheque);
                        }
                    }
                ),
        ];
    }
}
