<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryRelationManager extends RelationManager
{
    protected static string $relationship = 'project_task_categories';

    protected static ?string $title = 'Categorias';
    protected static ?string $label = 'Categoria';
    protected static ?string $pluralLabel = 'Categorias';



    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome')
                    ->required(),
                Forms\Components\ColorPicker::make('color')
                    ->label('Cor')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->badge()
                    ->color(function ($record) {
                        return Color::hex($record->color);
                    })->sortable(),
                Tables\Columns\ColorColumn::make('color')
                    ->label('Cor'),
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
