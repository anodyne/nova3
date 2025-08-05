@use('Nova\Stories\Enums\ContentRatingValue')

<x-form action="" wire:submit="save">
    <x-fieldset>
        <x-fieldset.heading>
            <x-icon :name="Icon::Rating18"></x-icon>
            <x-fieldset.legend>Default {{ $category }} rating</x-fieldset.legend>
            <x-fieldset.description>
                This is the default {{ $category }} content rating for your game. This is a good way to show current
                and interested players the type and level of content they can expect from your game.
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            <x-fieldset.field label="Rating" id="rating" name="rating">
                <livewire:rating :area="$category" wire:model.live="form.rating" />
            </x-fieldset.field>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading>
            <x-icon :name="Icon::Warning"></x-icon>
            <x-fieldset.legend>Rating threshold warning</x-fieldset.legend>
            <x-fieldset.description>
                You can choose to warn readers about potentially offensive content in a story post if that post meets
                certain thresholds.
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            <x-fieldset.field
                label="Warn readers when the post rating is at or above"
                id="warningThreshold"
                name="warningThreshold"
            >
                @if (filled($form->warningThreshold) && $form->warningThreshold < $form->rating)
                    <x-fieldset.warning-message>
                        You have chosen to warn readers about this content, but your threshold is set below the default
                        rating for this category. This means that readers will have to manually agree to a warning
                        before being allowed to read every story post unless an author specifically sets the category
                        rating lower for their post.
                    </x-fieldset.warning-message>
                @endif

                <flux:radio.group wire:model.live="form.warningThreshold" variant="segmented" data-slot="control">
                    @foreach (ContentRatingValue::casesForGameThreshold() as $rating)
                        <flux:radio :value="$rating->value" :label="$rating->getLabelForThreshold()" />
                    @endforeach
                </flux:radio.group>
            </x-fieldset.field>

            <x-fieldset.field label="Warning message" id="warningThresholdMessage" name="warningThresholdMessage">
                <x-input.text wire:model.live="form.warningThresholdMessage"></x-input.text>
            </x-fieldset.field>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset>
        <x-fieldset.heading>
            <x-icon :name="Icon::Blockquote"></x-icon>
            <x-fieldset.legend>Rating level descriptions</x-fieldset.legend>
            <x-fieldset.description>
                Customize the descriptions of what is permitted at each level of the rating scale.
            </x-fieldset.description>
        </x-fieldset.heading>

        <x-fieldset.field-group constrained>
            <x-fieldset.field label="Level 0" id="description0" name="description0">
                <x-input.textarea rows="1" wire:model.live="form.description0"></x-input.textarea>
            </x-fieldset.field>

            <x-fieldset.field label="Level 1" id="description1" name="description1">
                <x-input.textarea rows="1" wire:model.live="form.description1"></x-input.textarea>
            </x-fieldset.field>

            <x-fieldset.field label="Level 2" id="description2" name="description2">
                <x-input.textarea rows="1" wire:model.live="form.description2"></x-input.textarea>
            </x-fieldset.field>

            <x-fieldset.field label="Level 3" id="description3" name="description3">
                <x-input.textarea rows="1" wire:model.live="form.description3"></x-input.textarea>
            </x-fieldset.field>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-button type="submit" color="primary">Update</x-button>
    </x-fieldset.controls>
</x-form>
