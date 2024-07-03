@php
    $format = numfmt_create('pt_BR', NumberFormatter::CURRENCY);
    @endphp

<div
    id="{{ $record->getKey() }}"
    wire:click="recordClicked('{{ $record->getKey() }}', {{ @json_encode($record) }})"
    style="padding: 20px"
    class="record bg-white dark:bg-gray-700 bg-opacity-50 rounded-lg px-4 py-2 cursor-grab font-medium text-gray-600 dark:text-gray-200"
    @if($record->timestamps && now()->diffInSeconds($record->{$record::UPDATED_AT}) < 3)
        x-data
    @endif
>

        <div style="display: flex; flex-direction: column; justify-content: start; align-items: flex-start;">

            <div style="display: flex; flex-direction: row; align-content: center; justify-content: space-between; width: 100%; gap: 10px; margin-bottom: 10px">
                <h1  style="font-size: 15px">{{ $record['name'] }}</h1>
                @if($record['value'])
                    <h1  style="font-size: 15px; color: rgba(255,255,255, 0.5)">{{ numfmt_format_currency($format, $record['value'], 'BRL') }}</h1>
                @endif
            </div>

            @if($record['user'])
                <div style="display: flex; flex-direction: row; align-items: center; gap: 10px; margin-bottom: 10px">
                    <span style="width: 35px; height: 35px; font-size: 13px; background-color: rgba(96, 165, 250, 0.2); color: rgba(96, 165, 250, 1); border: 1px solid rgba(96, 165, 250, 1); border-radius: 500px;  display: flex; justify-content: center; align-items: center;">GA</span>
                    <h5 style="font-size: 15px; color: rgba(255,255,255, 0.5);">{{ $record['user']['name'] }}</h5>
                </div>
            @endif



        @if($record['empresa'])
            <h5 style="font-size: 15px; color: rgba(255,255,255, 0.5);"><b>Empresa: </b>{{ $record['empresa'] }}</h5>
        @endif
        @if($record['telefone'])
            <h5 style="font-size: 15px; color: rgba(255,255,255, 0.5);"><b>Telefone: </b>{{ $record['telefone'] }}</h5>
        @endif
        @if($record['email'])
            <h5 style="font-size: 15px; color: rgba(255,255,255, 0.5);"><b>E-mail: </b>{{ $record['email'] }}</h5>
        @endif
        @if($record['canal'])
            <h5 style="background-color: rgba(96, 165, 250, 0.2); width: auto; font-size: 15px; color: rgba(96, 165, 250); border: 1px solid rgba(96, 165, 250); padding: 5px 20px; border-radius: 200px; margin-top: 10px"><b></b>{{ $record['canal'] }}</h5>
        @endif

    </div>
</div>
