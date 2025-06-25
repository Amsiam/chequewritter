<?php

namespace App\Filament\Resources\BankResource\Pages;

use App\Filament\Imports\BankImporter;
use App\Filament\Resources\BankResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use HayderHatem\FilamentExcelImport\Actions\Concerns\CanImportExcelRecords;

class ManageBanks extends ManageRecords
{
    use CanImportExcelRecords;
    protected static string $resource = BankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->label('Bulk Import')
                ->importer(BankImporter::class)
        ];
    }
}
