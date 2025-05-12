<?php

namespace App\Filament\Resources\SaleResource\RelationManagers;

use App\Models\Receipt;
use App\Models\Sale;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification as NotificationsNotification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction as ActionsCreateAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Notification;
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction;

class ReceiptsRelationManager extends RelationManager
{
    protected static string $relationship = 'receipts';
    protected static ?string $relationshipLabel = 'Recebimentos';
    protected static ?string $label = 'Recebimenoto';
    protected static ?string $pluralLabel = 'Recebimentos';
    protected static ?string $title = 'Recebimentos';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Money::make('value')
                    ->label('Valor')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    protected function getCreateFormAction(): \Filament\Actions\Action
    {
        return parent::getCreateFormAction()
            ->disabled(function (): bool {
                return false;
            });
    }

    public function table(Table $table): Table
    {

        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('#'),
                Tables\Columns\TextColumn::make('value')->label('Valor')->money('BRL')->summarize(Sum::make('value')->label('Valor Recebido')->money('BRL')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->disabled(function (): bool {
                    $saleId = json_decode(json_decode(request()->getContent())->components[0]->snapshot)->data->ownerRecord[1]->key;
                    $receipts = Receipt::where('sale_id', $saleId)->get();
                    $receiptsValue = 0;
                    $sale = Sale::find($saleId);
                    foreach ($receipts as $receipt) {
                        $receiptsValue += $receipt->value;
                    }
                    if ($receiptsValue >= $sale->value) {
                        return true;
                    }
                    return false;
                }),
            ])
            ->actions([
                //CopyAction::make()->label('Copiar link de pagamento')->copyable(fn(Receipt $receipt) => $receipt->link),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
