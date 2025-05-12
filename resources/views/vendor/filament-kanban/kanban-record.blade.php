@php
    $format = numfmt_create('pt_BR', NumberFormatter::CURRENCY);
    @endphp

<div
    id="{{ $record->getKey() }}"
    wire:click="recordClicked('{{ $record->getKey() }}', {{ @json_encode($record) }})"
    style="padding: 20px; border-color: rgba(255,255,255,0.2); background-color: rgba(255,255,255,0.05);"
    class="record bg border  rounded-md px-4 py-2 cursor-grab font-medium "
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
                    <span style="font-size: 13px; background-color: rgba(96, 165, 250, 0.2); border-radius: 5px;  display: flex; justify-content: center; align-items: center; ">
                        <h5 style="font-size: 11px; color: white; padding: 3px 7px;">{{ $record['user']['name'] }}</h5>
                    </span>
                    
                </div>
            @endif



        @if($record['empresa'])
            <h5 style="font-size: 11px; color: rgba(255,255,255, 0.5);"><b>Empresa: </b>{{ $record['empresa'] }}</h5>
        @endif
        @if($record['telefone'])
            <h5 style="font-size: 11px; color: rgba(255,255,255, 0.5);"><b>Telefone: </b>{{ $record['telefone'] }}</h5>
        @endif
        @if($record['email'])
            <h5 style="font-size: 11px; color: rgba(255,255,255, 0.5);"><b>E-mail: </b>{{ $record['email'] }}</h5>
        @endif
        @if($record['canal'])
            <span style="margin-top: 10px; font-size: 13px; background-color: rgba(255, 0, 0, 0.2); border-radius: 5px;  display: flex; justify-content: center; align-items: center; ">
                <h5 style="font-size: 11px; color: white; padding: 3px 7px;">Canal: {{ $record['canal'] }}</h5>
            </span>
        @endif

    </div>
</div>
