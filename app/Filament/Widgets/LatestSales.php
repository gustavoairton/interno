<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestSales extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 1;
    protected static ?string $heading = 'Últimas vendas';

    use InteractsWithPageFilters;

    public function table(Table $table): Table
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

        return $table
            ->query(
                Sale::query()->whereBetween('created_at', [$start, $end])
            )
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Closer'),
                Tables\Columns\TextColumn::make('lead.name')
                    ->label('Lead'),
                Tables\Columns\TextColumn::make('service.name')
                    ->label('Serviço'),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('total_receipts_value')
                    ->label('Valor Recebido')
                    ->badge()
                    ->color(function (Sale $record) {
                        if ($record->total_receipts_value == 0) {
                            return 'danger';
                        } else if ($record->total_receipts_value < $record->value) {
                            return 'warning';
                        } else {
                            return 'success';
                        }
                    })
                    ->icon(function (Sale $record) {
                        if ($record->total_receipts_value == 0) {
                            return 'heroicon-o-x-mark';
                        } else if ($record->total_receipts_value < $record->value) {
                            return 'heroicon-o-clock';
                        } else {
                            return 'heroicon-m-check';
                        }
                    })
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
            ]);
    }
}
