@props(['status'])

<div class=" flex-shrink-0 min-h-full flex flex-col" style="width: 300px;">
    @include(static::$headerView)

    <div
        data-status-id="{{ $status['id'] }}"
        class="flex flex-col flex-1 gap-2 p-3 rounded-xl" style="border: 1px solid rgba(255,255,255,0.01);"
    >
        @foreach($status['records'] as $record)
            @include(static::$recordView)
        @endforeach
    </div>
</div>
