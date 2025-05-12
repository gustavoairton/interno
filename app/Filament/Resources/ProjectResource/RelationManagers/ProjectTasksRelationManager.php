<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Models\Project;
use App\Models\ProjectTaskCategory;
use Faker\Core\Color;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color as ColorsColor;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectTasksRelationManager extends RelationManager
{
    protected static string $relationship = 'project_tasks';

    protected static ?string $title = 'Tarefas';
    protected static ?string $label = 'Tarefa';
    protected static ?string $pluralLabel = 'Tarefas';



    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                Forms\Components\Select::make('category')
                    ->label('Categoria')
                    ->options(function () {
                        $catgories = ProjectTaskCategory::where('project_id', $this->ownerRecord->id)->get();
                        return $catgories->pluck('name', 'id');
                    })
                    ->required(),
                Forms\Components\TextInput::make('days')
                    ->label('Dias')
                    ->numeric()
                    ->required(),
                Forms\Components\Hidden::make('project_id'),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'doing' => 'Em andamento',
                        'done' => 'Concluído',
                    ])
                    ->default('pending')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('project_task_category.name')
                    ->label('Categoria')
                    ->badge()
                    ->color(function ($record) {
                        return ColorsColor::hex($record->project_task_category->color);
                    })->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('days')
                    ->label('Dias'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(function ($state) {
                        if ($state == 'pending') {
                            return 'Pendente';
                        } elseif ($state == 'doing') {
                            return 'Em andamento';
                        } else {
                            return 'Concluído';
                        }
                    })
                    ->color(function ($state) {
                        if ($state == 'pending') {
                            return 'warning';
                        } elseif ($state == 'doing') {
                            return 'info';
                        } else {
                            return 'success';
                        }
                    }),
            ])
            ->reorderable('order')
            ->defaultSort('order')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                ActionsAction::make('doing')
                    ->label('Marcar como em andamento')
                    ->action(function ($record) {
                        $record->status = 'doing';
                        $record->save();
                    })
                    ->color('info')
                    ->icon('heroicon-o-clock')
                    ->requiresConfirmation()
                    ->visible(function ($record) {
                        return $record->status == 'pending';
                    }),
                ActionsAction::make('done')
                    ->label('Concluir tarefa')
                    ->action(function ($record) {
                        $record->status = 'done';
                        $record->save();
                    })
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->visible(function ($record) {
                        return $record->status == 'doing';
                    }),
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
