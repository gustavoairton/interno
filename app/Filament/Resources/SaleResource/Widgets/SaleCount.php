<?php

namespace App\Filament\Resources\AssistantResource\Widgets;

use Filament\Widgets\Widget;

class SaleCount extends Widget
{
    protected static string $view = 'filament.resources.sale-resource.widgets.sale-count';
    public string $assistant;
}
