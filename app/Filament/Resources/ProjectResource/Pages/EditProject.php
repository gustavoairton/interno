<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\SaleResource;
use App\Models\Project;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Webbingbrasil\FilamentCopyActions\Pages\Actions\CopyAction;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            CopyAction::make()->label('Copiar link público')->copyable(fn(Project $project) => 'https://cliente.bexond.com/' . $project->id)->color('success'),

        ];
    }
}
