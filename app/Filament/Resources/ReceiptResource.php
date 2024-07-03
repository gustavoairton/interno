<?php

namespace App\Filament\Resources;

use Akaunting\Money\View\Components\Money;
use App\Filament\Resources\ReceiptResource\Pages;
use App\Filament\Resources\ReceiptResource\RelationManagers;
use App\Models\Receipt;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields\Money as FilamentPtbrFormFieldsMoney;

class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;
    protected static ?string $navigationGroup = 'Financeiro';
    protected static ?string $navigationLabel = 'Recebimentos';
    protected static ?string $label = 'Fatura';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?bool $readOnly = true;

    public static function canViewAny(): bool
    {
        $user = User::find(auth()->user()->id);
        return $user->hasPermission('recebimento');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sale_id')->relationship('sale', 'id')->required()->prefix('Venda #')->label('Venda')->searchable()->extraInputAttributes([
                    'readOnly' => true,
                ]),
                FilamentPtbrFormFieldsMoney::make('value')->label('Valor')->required()->readOnly(true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sale.id')
                    ->prefix('Venda #')
                    ->label('Venda')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')->label('Valor')->money('BRL'),
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->color('success'),
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
            'index' => Pages\ListReceipts::route('/'),
            'create' => Pages\CreateReceipt::route('/create'),
            'view' => Pages\ViewReceipt::route('/view/{record}'),
            'edit' => Pages\EditReceipt::route('/{record}/edit'),
        ];
    }
}
