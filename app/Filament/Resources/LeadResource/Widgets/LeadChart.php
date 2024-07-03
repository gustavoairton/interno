<?php

namespace App\Filament\Resources\SaleResource\Widgets;

use App\Models\Lead;
use App\Models\Sale;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class LeadChart extends ChartWidget
{
    protected static ?string $heading = 'Leads';
    protected static ?string $description = 'Referência: Este ano.';

    protected function getData(): array
    {

        $data = Trend::model(Lead::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        $format = numfmt_create('pt_BR', \NumberFormatter::CURRENCY);

        return [
            'datasets' => [
                [
                    'label' => 'Leads Criados',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),

                    ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
