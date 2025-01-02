<x-modal
    :icon="
        match (true) {
            $isReplying => 'message-reply',
            $isChangingName => 'form',
            default => 'message'
        }
    "
    :title="
        match (true) {
            $isReplying => 'Reply',
            $isChangingName => 'Update group name',
            default => 'New message'
        }
    "
>
    <x-form action="">
        <x-fieldset>
            <x-fieldset.field-group>
                @if (! $isReplying && ! $isChangingName)
                    <x-fieldset.field label="To" id="to" name="to">
                        <x-select wire:model.live="recipients" multiple>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </x-select>

                        <div class="text-base/6 text-gray-500 sm:text-sm/6 dark:text-gray-400" data-slot="help">
                            Hold control and click to select multiple users
                        </div>
                    </x-fieldset.field>
                @endif

                @if (count($recipients) > 1 || $isChangingName)
                    <x-fieldset.field
                        label="Group message name"
                        description="Group messages have more than 2 participants. You can optionally choose to name group messages to better identify them."
                        id="name"
                        name="name"
                    >
                        <x-input.text wire:model.live.debounce.500ms="name"></x-input.text>
                    </x-fieldset.field>
                @endif

                @if (! $isChangingName)
                    <x-fieldset.field label="Message" id="message" name="message">
                        <x-input.textarea rows="7" wire:model.live.debounce.500ms="content"></x-input.textarea>
                    </x-fieldset.field>
                @endif
            </x-fieldset.field-group>
        </x-fieldset>

        <x-fieldset.controls>
            @if ($isReplying)
                <x-button type="button" wire:click="reply" color="primary">Reply</x-button>
            @endif

            @if ($isChangingName)
                <x-button type="button" wire:click="updateName" color="primary">Update</x-button>
            @endif

            @if (! $isReplying && ! $isChangingName)
                <x-button type="button" wire:click="submit" color="primary">Submit</x-button>
            @endif

            <x-button type="button" wire:click="dismiss">Cancel</x-button>
        </x-fieldset.controls>
    </x-form>
</x-modal>
