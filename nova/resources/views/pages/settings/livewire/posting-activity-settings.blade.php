@use('Nova\Settings\Enums\PostingTarget')
@use('Nova\Settings\Enums\PostingTimeframe')

<x-form action="" wire:submit="save">
    <x-fieldset>
        <x-fieldset.heading>
            <x-icon name="tabler-gavel"></x-icon>
            <x-fieldset.legend>Activity requirements</x-fieldset.legend>
            <x-fieldset.description>Set the game’s activity requirements for players.</x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            <x-fieldset.field
                label="Posting requirements"
                description="Players will be expected to meet these posting requirements at the activity timeframe specified below"
                :error="$errors->first('form.requirement')"
            >
                <div class="flex items-center gap-x-4" data-slot="control">
                    <x-input.text
                        name="requirement"
                        id="requirement"
                        wire:model.numeric="form.requirement"
                    ></x-input.text>

                    <x-select name="target" id="target" wire:model="form.target">
                        @foreach (PostingTarget::cases() as $target)
                            <option value="{{ $target->value }}">
                                {{ $target->getLabel() }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </x-fieldset.field>

            <x-fieldset.field
                label="Activity timeframe"
                description="Players will be required to meet the above posting requirements at this interval"
            >
                <x-radio.group>
                    @foreach (PostingTimeframe::cases() as $timeframe)
                        <x-radio.field>
                            <x-fieldset.label for="type_{{ $timeframe->value }}">
                                {{ $timeframe->getLabel() }}
                            </x-fieldset.label>
                            <x-fieldset.description>
                                {{ $timeframe->getDescription() }}
                            </x-fieldset.description>
                            <x-radio
                                id="type_{{ $timeframe->value }}"
                                :value="$timeframe->value"
                                wire:model.live="form.timeframe"
                            ></x-radio>
                        </x-radio.field>
                    @endforeach
                </x-radio.group>
            </x-fieldset.field>

            @if ($form->timeframe === PostingTimeframe::Rolling)
                <x-fieldset.field
                    label="Number of days"
                    name="rollingDays"
                    id="rollingDays"
                    :error="$errors->first('form.rollingDays')"
                >
                    <x-input.text wire:model.numeric="form.rollingDays"></x-input.text>
                </x-fieldset.field>
            @endif
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-button type="submit" color="primary">Update</x-button>
    </x-fieldset.controls>
</x-form>
