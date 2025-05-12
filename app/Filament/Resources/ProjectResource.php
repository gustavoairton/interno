<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Filament\Resources\ProjectResource\RelationManagers\ProjectTasksRelationManager;
use App\Filament\Resources\ProjectResource\Pages\EditProject;
use App\Filament\Resources\ProjectResource\RelationManagers\CategoryRelationManager;
use App\Models\Lead;
use App\Models\Project;
use App\Models\Sale;
use App\Models\Service;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Operacional';
    protected static ?string $label = 'Projeto';
    protected static ?string $pluralLabel = 'Projetos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nome do Projeto')
                    ->maxLength(255),
                Forms\Components\TextInput::make('business_name')
                    ->required()
                    ->label('Nome da Empresa')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('logo_url')
                    ->label('Logo')
                    ->image()
                    ->directory('project-logos')
                    ->visibility('public')
                    ->required(),
                Forms\Components\Select::make('sale_id')
                    ->label('Venda')
                    ->options(function () {
                        $options = [];
                        foreach (Sale::all()->sortByDesc('created_at') as $sale) {
                            $lead = Lead::find($sale->lead_id);
                            $service = Service::find($sale->service_id);
                            $options[$sale->id] = 'Venda #' . $sale->id . ' | Lead: ' . $lead->name . ' | Serviço: ' . $service->name;
                        }
                        return $options;
                    })
                    ->required(),
                Forms\Components\Select::make('template')
                    ->label('Template')
                    ->options([
                        'website' => 'Website',
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome do Projeto')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sale.lead.name')
                    ->numeric()
                    ->label('Cliente')
                    ->sortable(),
                TextColumn::make('logo_url')
                    ->label('Logo'),
                TextColumn::make('business_name')
                    ->label('Nome da Empresa')
                    ->badge()
                    ->color('success')
                    ->searchable(),
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
                CopyAction::make()->label('Copiar link público')->copyable(fn(Project $project) => 'https://cliente.bexond.com/' . $project->id)->color('success'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            ProjectTasksRelationManager::class,
            CategoryRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProjects::route('/'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
