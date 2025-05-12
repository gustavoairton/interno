<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Lead;
use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class LeadChart extends ChartWidget
{
    protected static ?string $heading = 'Leads';
    protected static ?string $description = 'Referência: Este ano.';

    use InteractsWithPageFilters;

    protected function getData(): array
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

        if ($activeFilter === 'year') {
            $data = Trend::model(Lead::class)
                ->between(
                    start: $start,
                    end: now()->endOfYear(),
                )
                ->perMonth()
                ->count();


            return [
                'datasets' => [
                    [
                        'label' => 'Valor em Vendas',
                        'data' => $data->map(fn(TrendValue $value) => $value->aggregate),

                    ],
                ],
                'labels' => $data->map(fn(TrendValue $value) => $value->date),
            ];
        } else if ($activeFilter === '90') {
            $data = Trend::model(Lead::class)
                ->between(
                    start: now()->subDays(90)->startOfDay(),
                    end: now()->endOfDay(),
                )
                ->perMonth()
                ->count();

            return [
                'datasets' => [
                    [
                        'label' => 'Leads Criados',
                        'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    ],
                ],
                'labels' => $data->map(fn(TrendValue $value) => $value->date),
            ];
        } else {
            $data = Trend::model(Lead::class)
                ->between(
                    start: $start,
                    end: $end,
                )
                ->perDay()
                ->count();

            return [
                'datasets' => [
                    [
                        'label' => 'Leads Criados',
                        'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    ],
                ],
                'labels' => $data->map(fn(TrendValue $value) => $value->date),
            ];
        }
    }

    protected function getType(): string
    {
        return 'line';
    }
}
