<x-filament.modal-content :$action :icon="Tabler::BrandDiscord" title="Discord settings">
    <x-text>
        You can set the settings for the Discord webhook and accent color for the
        <strong>{{ $record->name }}</strong>
        notification below.
    </x-text>

    @if (filled($record->notes))
        <x-callout.primary heading="Please note">
            {{ $record->notes }}
        </x-callout.primary>
    @endif

    <hr class="my-4 border-gray-950/10 dark:border-white/10" />
</x-filament.modal-content>
