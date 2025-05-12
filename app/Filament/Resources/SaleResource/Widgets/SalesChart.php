<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Sale;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SalesChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Vendas';
    protected static ?string $description = 'Referência: Este ano.';
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
            $data = Trend::model(Sale::class)
                ->between(
                    start: $start,
                    end: now()->endOfYear()
                )
                ->perMonth()
                ->sum('value');

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
            $data = Trend::model(Sale::class)
                ->between(
                    start: now()->subDays(90)->startOfDay(),
                    end: now()->endOfDay()
                )
                ->perMonth()
                ->sum('value');

            return [
                'datasets' => [
                    [
                        'label' => 'Valor em Vendas',
                        'data' => $data->map(fn(TrendValue $value) => $value->aggregate),

                    ],
                ],
                'labels' => $data->map(fn(TrendValue $value) => $value->date),
            ];
        } else {
            $data = Trend::model(Sale::class)
                ->between(
                    start: $start,
                    end: $end
                )
                ->perDay()
                ->sum('value');

            return [
                'datasets' => [
                    [
                        'label' => 'Valor em Vendas',
                        'data' => $data->map(fn(TrendValue $value) => $value->aggregate),

                    ],
                ],
                'labels' => $data->map(fn(TrendValue $value) => $value->date),
            ];
        }
    }

    protected function getOptions(): RawJs
    {
        $format = numfmt_create('pt_BR', \NumberFormatter::CURRENCY);

        return RawJs::make(<<<JS
        {
    plugins: {
            tooltip: {
                callbacks: {
                    label: function (value){
                        return 'Valor em vendas: ' + value.raw.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL'});
                    }
                }
            }
        },
            scales: {
                y: {
                    ticks: {
                        callback: (value) => new Intl.NumberFormat('en-US', { style: 'currency', currency: 'BRL'}).format(value),
                    },
                },
            },
        }
    JS);
    }

    protected function getType(): string
    {
        return 'line';
    }
}
