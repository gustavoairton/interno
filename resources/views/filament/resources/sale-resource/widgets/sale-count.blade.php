@php
    $format = numfmt_create('pt_BR', NumberFormatter::CURRENCY);
@endphp

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center gap-x-3 justify-between" style="width: 100%">
            <div>
                <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">Valor</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">de vendas</p>
            </div>

            <div>
                <h1 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white" style="font-size:30px;">{{ numfmt_format_currency($format, \App\Models\Sale::sum('value'), 'BRL') }}</h1>
            </div>
        </div>

    </x-filament::section>
</x-filament-widgets::widget>
