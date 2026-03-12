@use('Nova\Users\Enums\Appearance')

<x-radio.group variant="segmented" wire:model.live="appearance" class="@container">
    @foreach (Appearance::cases() as $appearance)
        <x-radio :value="$appearance->value" :icon="$appearance->getIcon()">
            <x-slot name="label">
                <div class="@max-sm:hidden">{{ $appearance->getLabel() }}</div>
            </x-slot>
        </x-radio>
    @endforeach
</x-radio.group>
