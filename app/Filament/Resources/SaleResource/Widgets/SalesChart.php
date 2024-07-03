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
    protected function getData(): array
    {

        $data = Trend::model(Sale::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
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
                        callback: (value) => new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL'}).format(value),
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
