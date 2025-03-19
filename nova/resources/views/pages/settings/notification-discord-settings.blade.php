<x-filament.modal-content :$action icon="brand-discord" title="Discord settings">
    <x-text>
        You can set the settings for the Discord webhook and accent color for the
        <strong class="font-semibold">{{ $record->name }}</strong>
        notification below.
    </x-text>

    @if (filled($record->notes))
        <x-panel.primary title="Please note" :description="$record->notes"></x-panel.primary>
    @endif

    <hr class="my-6" />
</x-filament.modal-content>
