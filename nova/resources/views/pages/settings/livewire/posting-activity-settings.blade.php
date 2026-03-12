@use('Nova\Settings\Enums\PostingTarget')
@use('Nova\Settings\Enums\PostingTimeframe')

<x-form action="" wire:submit="save">
    <x-fieldset>
        <x-fieldset.heading :icon="Tabler::Gavel" heading="Activity requirements">
            <x-description>Set the game’s activity requirements for players.</x-description>
        </x-fieldset.heading>

        <x-fieldset.group constrained>
            <x-field>
                <x-label>Posting requirements</x-label>

                <x-description>
                    Players will be expected to meet these posting requirements at the activity timeframe specified
                    below
                </x-description>

                <div class="grid grid-cols-2 gap-4">
                    <x-input.number wire:model.numeric="form.requirement" />

                    <x-select wire:model="form.target">
                        @foreach (PostingTarget::cases() as $target)
                            <option value="{{ $target->value }}">
                                {{ $target->getLabel() }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </x-field>

            <x-radio.group
                label="Activity timeframe"
                description="Players will be required to meet the above posting requirements at this interval"
                wire:model.live="form.timeframe"
            >
                @foreach (PostingTimeframe::cases() as $timeframe)
                    <x-radio
                        :label="$timeframe->getLabel()"
                        :description="$timeframe->getDescription()"
                        :value="$timeframe->value"
                    />
                @endforeach
            </x-radio.group>

            @if ($form->timeframe === PostingTimeframe::Rolling)
                <div class="w-full sm:w-1/2">
                    <x-input.number label="Number of days" wire:model.numeric="form.rollingDays" />
                </div>
            @endif
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-button type="submit" variant="primary">Update</x-button>
    </x-fieldset.controls>
</x-form>
