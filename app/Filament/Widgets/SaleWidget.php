<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\Receipt;
use App\Models\Sale;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use NumberFormatter;

class SaleWidget extends BaseWidget
{

    use InteractsWithPageFilters;

    protected function getStats(): array
    {

        $activeFilter = $this->filters['filter'];
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        if ($activeFilter === 'month') {
            $start = now()->startOfMonth()->startOfDay();
            $end = now()->endOfMonth()->endOfDay();
        }
        if ($activeFilter === '7') {
            $start = now()->subDays(7)->startOfDay();
            $end = now()->endOfDay();
        }
        if ($activeFilter === '30') {
            $start = now()->subDays(30)->startOfDay();
            $end = now()->endOfDay();
        }
        if ($activeFilter === '90') {
            $start = now()->subDays(90)->startOfDay();
            $end = now()->endOfDay();
        }
        if ($activeFilter === 'year') {
            $start = now()->startOfYear()->startOfDay();
            $end = now()->endOfYear()->endOfDay();
        }

        $sales = Receipt::whereBetween('created_at', [$start, $end])->get();
        $leads = Lead::whereBetween('created_at', [$start, $end])->get();
        $convertedLeads = Lead::whereBetween('converted_at', [$start, $end])->get();
        $total = $sales->sum('value');

        $format = NumberFormatter::create('pt_BR', NumberFormatter::CURRENCY);
        $total = $format->formatCurrency($total, 'BRL');

        return [
            Stat::make('Entradas', $total),
            Stat::make('Leads criados', $leads->count()),
            Stat::make('Novos clientes', $convertedLeads->count()),
        ];
    }
}
