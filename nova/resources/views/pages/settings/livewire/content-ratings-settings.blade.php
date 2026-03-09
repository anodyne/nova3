@use('Nova\Stories\Enums\ContentRatingValue')

<x-form action="" wire:submit="save">
    <x-fieldset>
        <x-fieldset.heading :icon="Tabler::Rating18Plus">
            <x-slot name="heading">Default {{ $category }} rating</x-slot>
            <x-description>
                This is the default {{ $category }} content rating for your game. This is a good way to show current
                and interested players the type and level of content they can expect from your game.
            </x-description>
        </x-fieldset.heading>

        <x-fieldset.group constrained>
            <x-field>
                <x-label>Rating</x-label>
                <livewire:rating :area="$category" wire:model.live="form.rating" />
            </x-field>
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading :icon="Tabler::AlertTriangle" heading="Rating threshold warning">
            <x-description>
                You can choose to warn readers about potentially offensive content in a story post if that post meets
                certain thresholds.
            </x-description>
        </x-fieldset.heading>

        <x-fieldset.group constrained>
            <x-field>
                <x-label>Warn readers when the post rating is at or above</x-label>

                @if (filled($form->warningThreshold) && $form->warningThreshold->value < $form->rating->value)
                    <x-callout.warning data-flux-description>
                        You have chosen to warn readers about this content, but your threshold is set below the default
                        rating for this category. This means that readers will have to manually agree to a warning
                        before being allowed to read every story post unless an author specifically sets the category
                        rating lower for their post.
                    </x-callout.warning>
                @endif

                <x-radio.group wire:model.numeric.live="form.warningThreshold" variant="segmented">
                    @foreach (ContentRatingValue::casesForGameThreshold() as $rating)
                        <x-radio :value="$rating->value" :label="$rating->getLabelForThreshold()" />
                    @endforeach
                </x-radio.group>
            </x-field>

            <x-input label="Warning message" wire:model.blur="form.warningThresholdMessage" />
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading :icon="Tabler::Blockquote" heading="Rating level descriptions">
            <x-description>
                Customize the descriptions of what is permitted at each level of the rating scale.
            </x-description>
        </x-fieldset.heading>

        <x-fieldset.group constrained>
            <x-textarea label="Level 0" wire:model.blur="form.description0" rows="auto"></x-textarea>

            <x-textarea label="Level 1" wire:model.blur="form.description1" rows="auto"></x-textarea>

            <x-textarea label="Level 2" wire:model.blur="form.description2" rows="auto"></x-textarea>

            <x-textarea label="Level 3" wire:model.blur="form.description3" rows="auto"></x-textarea>
        </x-fieldset.group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-button type="submit" variant="primary">Update</x-button>
    </x-fieldset.controls>
</x-form>
