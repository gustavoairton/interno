@props(['status'])

<div class="md:w-[24rem] flex-shrink-0 min-h-full flex flex-col">
    @include(static::$headerView)

    <div
        data-status-id="{{ $status['id'] }}"
        class="flex flex-col flex-1 gap-2 p-3 rounded-xl" style="background-color: rgba(0, 0, 0, 0.1);"
    >
        @foreach($status['records'] as $record)
            @include(static::$recordView)
        @endforeach
    </div>
</div>
