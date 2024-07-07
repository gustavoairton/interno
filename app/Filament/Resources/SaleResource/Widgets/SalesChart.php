<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Sale;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Vendas';
    protected static ?string $description = 'Referência: Este ano.';

    protected function getData(): array
    {

        $activeFilter = $this->filter;
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        if ($activeFilter === 'month') {
            $start = now()->startOfMonth();
            $end = now()->endOfMonth();
        }

        if ($activeFilter === 'week') {
            $start = now()->startOfWeek();
            $end = now()->endOfWeek();
        }

        if ($activeFilter === 'year') {
            $start = now()->startOfYear();
            $end = now()->endOfYear();
        }

        if ($activeFilter === 'year') {
            $data = Trend::model(Sale::class)
                ->between(
                    start: $start,
                    end: $end
                )
                ->perMonth()
                ->sum('value');

            return [
                'datasets' => [
                    [
                        'label' => 'Valor em Vendas',
                        'data' => $data->map(fn (TrendValue $value) => $value->aggregate),

                    ],
                ],
                'labels' => $data->map(fn (TrendValue $value) => $value->date),
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
                        'data' => $data->map(fn (TrendValue $value) => $value->aggregate),

                    ],
                ],
                'labels' => $data->map(fn (TrendValue $value) => $value->date),
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

    protected function getFilters(): ?array
    {
        return [
            'month' => 'Este mês',
            'week' => 'Esta semana',
            'year' => 'Este ano',
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
