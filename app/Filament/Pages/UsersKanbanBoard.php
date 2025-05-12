<?php

namespace App\Filament\Pages;

use App\Enums\LeadStatuses;
use App\Models\Lead;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;
use App\Filament\Resources\LeadResource\Pages;
use App\Models\Sale;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Actions\Action;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

class UsersKanbanBoard extends KanbanBoard
{

    protected static ?string $title = 'Kanban';
    protected static ?string $navigationGroup = 'Leads';

    protected static string $model = Lead::class;
    protected static string $statusEnum = LeadStatuses::class;

    protected string $editModalTitle = 'Editar Lead';
    protected string $editModalCancelButtonLabel = 'Cancelar';
    protected string $editModalSaveButtonLabel = 'Salvar';


    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('filter')
                    ->label('Filtrar por Período')
                    ->options([
                        'month' => 'Este Mês',
                        'year' => 'Este Ano',
                        '7' => 'Últimos 7 dias',
                        '30' => 'Últimos 30 dias',
                        '90' => 'Últimos 90 dias',
                    ])
                    ->default('month')->columnStart(5)->hiddenLabel(),
            ])->columns(5);
    }

    protected function getTableQuery(): Builder
    {
        $user = User::find(auth()->user()->id);
        return parent::getTableQuery()->where('user_id', $user->id);
    }

    public static function canAccess(): bool
    {
        $user = User::find(auth()->user()->id);
        return $user->hasPermission('comercial');
    }


    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->model(Lead::class)->form(
                [
                    Forms\Components\TextInput::make('name')
                        ->required()->label('Nome')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('telefone')
                        ->tel()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('site')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('empresa')
                        ->maxLength(255),
                    \Leandrocfe\FilamentPtbrFormFields\Money::make('value')->label('Valor'),
                    Forms\Components\Select::make('user_id')->relationship('user', 'name')->label('Closer'),
                    Forms\Components\TextInput::make('canal')
                        ->maxLength(255),
                    Forms\Components\RichEditor::make('texto'),
                ]
            )
        ];
    }

    protected function getEditModalFormSchema(?int $recordId): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->required()->label('Nome')
                ->maxLength(255),
            Forms\Components\TextInput::make('telefone')
                ->tel()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->maxLength(255),
            Forms\Components\TextInput::make('site')
                ->maxLength(255),
            Forms\Components\TextInput::make('empresa')
                ->maxLength(255),
            Forms\Components\TextInput::make('canal')
                ->maxLength(255),
            \Leandrocfe\FilamentPtbrFormFields\Money::make('value')->label('Valor'),
            Forms\Components\RichEditor::make('texto'),
        ];
    }

    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {

        $lead = Lead::find($recordId);

        if ($status === 'Negócio Fechado') {
            $lead->update([
                'converted_at' => now(),
            ]);
        } else {
            if ($lead->converted_at) {
                $lead->update([
                    'converted_at' => null,
                ]);
            }
        }

        $lead->update(['status' => $status]);

        Notification::make()->success()->title('Estado do Lead alterado para ' . $status . '.')->send();
    }
}
