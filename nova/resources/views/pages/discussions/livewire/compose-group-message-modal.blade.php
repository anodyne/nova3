<x-modal icon="users-group">
    <x-slot name="title">{{ filled($discussion) ? 'Update' : 'New' }} group message</x-slot>

    <x-form action="">
        <x-text size="lg">
            Group messages are conversations between you and any number of users. You can rename the conversation and
            add/remove users from the conversations. If you do not want other users to be added to the conversation, you
            should start a direct message.
        </x-text>

        <x-fieldset>
            <x-fieldset.field-group>
                <x-fieldset.field label="To" id="to" name="to">
                    <x-select wire:model.live="recipients" multiple>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-select>

                    <div class="text-base/6 text-gray-500 dark:text-gray-400 sm:text-sm/6" data-slot="help">
                        Hold control and click to select multiple users
                    </div>
                </x-fieldset.field>

                <x-fieldset.field
                    label="Group message name"
                    description="You can optionally name group messages to better help identify them"
                    id="name"
                    name="name"
                >
                    <x-input.text wire:model.live.debounce.500ms="name"></x-input.text>
                </x-fieldset.field>

                @if (blank($this->discussion))
                    <x-fieldset.field label="Message" id="message" name="message">
                        <x-input.textarea rows="5" wire:model.live.debounce.500ms="content"></x-input.textarea>
                    </x-fieldset.field>
                @endif
            </x-fieldset.field-group>
        </x-fieldset>

        <x-fieldset.controls>
            @if (filled($this->discussion))
                <x-button type="button" wire:click="update" color="primary">Update</x-button>
            @else
                <x-button type="button" wire:click="submit" color="primary">Submit</x-button>
            @endif

            <x-button type="button" wire:click="dismiss">Cancel</x-button>
        </x-fieldset.controls>
    </x-form>
</x-modal>
