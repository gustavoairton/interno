<x-filament-panels::page>
    <div x-data wire:ignore.self class="md:flex overflow-x-auto overflow-y-scroll gap-4 custom-scrollbar" style="height: 80vh; width: 100%; margin-bottom: -60px; ">
        @foreach($statuses as $status)
            @include(static::$statusView)
        @endforeach

        <div wire:ignore>
            @include(static::$scriptsView)
        </div>
    </div>

    @unless($disableEditModal)
        <x-filament-kanban::edit-record-modal/>
    @endunless
</x-filament-panels::page>
