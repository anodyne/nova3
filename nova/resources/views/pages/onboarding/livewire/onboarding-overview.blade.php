<div>
    @if ($activeOnboardings->count() > 0)
        @if ($activeOnboardings->count() > 1)
            <flux:tabs wire:model.live="selected" variant="pills" x-cloak>
                @foreach ($activeOnboardings as $onboarding)
                    <flux:tab :name="$onboarding->key->value">{{ $onboarding->name }}</flux:tab>
                @endforeach
            </flux:tabs>
        @endif

        <div class="mt-12">
            <livewire:dynamic-component :is="$onboardingComponent"></livewire:dynamic-component>
        </div>
    @else
        <x-empty-state>
            <x-illustration name="empty-onboarding" size="2xl"></x-illustration>
            <x-h2>No active onboardings</x-h2>
            <x-text>Congrats, everything has been setup.</x-text>
        </x-empty-state>
    @endif
</div>
