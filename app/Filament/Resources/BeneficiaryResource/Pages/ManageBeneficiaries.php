<?php

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Filament\Resources\BeneficiaryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageBeneficiaries extends ManageRecords
{
    protected static string $resource = BeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->mutateFormDataUsing(
                function (array $data): array {
                    $data['user_id'] = auth()->user()->id;
                    return $data;
                }
            ),
            Actions\ImportAction::make()
                ->label('Bulk Import')
                ->job(false)
                ->importer(\App\Filament\Imports\BeneficiaryImporter::class)
        ];
    }
}
