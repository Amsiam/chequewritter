<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChequeResource\Pages;
use App\Filament\Resources\ChequeResource\RelationManagers;
use App\Models\Bank;
use App\Models\Cheque;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChequeResource extends Resource
{
    protected static ?string $model = Cheque::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cheque_number_start')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cheque_number_end')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('bank_id')
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search): array => Bank::where('name', 'like', "%{$search}%")->limit(10)->pluck('name', 'id')->toArray())
                    ->getOptionLabelUsing(fn($value): ?string => Bank::find($value)?->name),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cheque_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'used' => 'warning'
                    })->icon(fn(string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'used' => 'heroicon-o-check'
                    })
                    ->badge(),
                // Tables\Columns\TextColumn::make('user.name')
                //     ->searchable()
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('bank.name')
                    ->searchable()
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options([
                        'pending' => 'Pending',
                        'used' => 'Used',
                    ]),
                SelectFilter::make('bank_id')
                    ->label('Bank')
                    ->multiple()
                    ->relationship('bank', 'name')
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCheques::route('/'),
        ];
    }
}
