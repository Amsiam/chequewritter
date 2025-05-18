<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChequeWriteResource\Pages;
use App\Filament\Resources\ChequeWriteResource\RelationManagers;
use App\Models\Bank;
use App\Models\Cheque;
use App\Models\ChequeWrite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChequeWriteResource extends Resource
{
    protected static ?string $model = ChequeWrite::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('bank_id')
                    ->label('Bank')
                    ->searchable()
                    ->relationship('bank', 'name')
                    ->getSearchResultsUsing(fn(string $search): array => Bank::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                    ->getOptionLabelsUsing(fn(array $value): array => Bank::where('id', $value)->pluck('name', 'id')->toArray())
                    ->afterStateUpdated(fn(Set $set) => $set('cheque_id', null))
                    ->live(onBlur: true)
                    ->required(),
                Forms\Components\Select::make('cheque_id')
                    ->label('Cheque No')
                    ->searchable()
                    ->relationship('cheque', 'cheque_number')
                    ->getSearchResultsUsing(fn(string $search, Get $get): array => Cheque::where('cheque_number', 'like', "%{$search}%")->where('bank_id', $get('bank_id'))->limit(50)->pluck('cheque_number', 'id')->toArray())
                    ->getOptionLabelsUsing(fn(array $value, Get $get): array => Cheque::where('id', $value)->where('bank_id', $get('bank_id'))->pluck('cheque_number', 'id')->toArray())
                    ->required(),
                Forms\Components\TextInput::make('payee')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cheque.cheque_number')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bank.name')
                    ->sortable(),
                // Tables\Columns\TextColumn::make('user_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('payee')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort('created_at')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChequeWrites::route('/'),
            'create' => Pages\CreateChequeWrite::route('/create'),
            'edit' => Pages\EditChequeWrite::route('/{record}/edit'),
        ];
    }
}
