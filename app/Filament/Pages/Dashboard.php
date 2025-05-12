<?php

namespace App\Filament\Pages;

use App\Filament\Resources\AssistantResource\Widgets\SaleCount;
use App\Filament\Resources\SaleResource\Widgets\LeadChart;
use App\Filament\Resources\SaleResource\Widgets\SalesChart;
use App\Filament\Widgets\LatestSales;
use App\Filament\Widgets\SaleWidget;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Pages\Page;
use Filament\Widgets\AccountWidget;
use Illuminate\Support\HtmlString;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'Dashboard';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = '';


    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('test')->hiddenLabel()->content(new HtmlString('<h1 class="text-2xl font-semibold mt-1">Dashboard</h1>')),
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

    public function getWidgets(): array
    {
        return [
            SaleWidget::class,
            SalesChart::class,
            LeadChart::class,
            LatestSales::class,
        ];
    }
}
