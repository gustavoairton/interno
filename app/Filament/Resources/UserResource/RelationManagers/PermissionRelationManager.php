<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Enums\Permissions;
use App\Models\Receipt;
use App\Models\Sale;
use Faker\Provider\ar_EG\Text;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

class PermissionRelationManager extends RelationManager
{

    protected static string $relationship = 'permissions';
    protected static ?string $relationshipLabel = 'Permissões';
    protected static ?string $label = 'Permissões';
    protected static ?string $title = 'Permissões';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('permission')->label('Permissão')->required()->options(Permissions::enumPermissions),
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
                Tables\Columns\TextColumn::make('permission')->label('Permissão')->badge(),
                Tables\Columns\TextColumn::make('created_at')->label('Adicionada em')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
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
