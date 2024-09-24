<x-modal title="New direct message" icon="user">
    <x-form action="">
        <x-text size="lg">
            Direct messages are private conversations between you and one other user. Additional users cannot be added
            to these conversations and will only ever be between you and the recipient. If you would like to allow
            multiple recipients or would like the ability to add additional users to the conversation in the future, you
            should start a group message.
        </x-text>

        <x-fieldset>
            <x-fieldset.field-group>
                <x-fieldset.field label="To" id="to" name="to">
                    <x-select wire:model.live="recipient">
                        <option value="">Who do you want to send a direct message to?</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-select>
                </x-fieldset.field>

                <x-fieldset.field label="Message" id="message" name="message">
                    <x-input.textarea rows="5" wire:model.live.debounce.500ms="content"></x-input.textarea>
                </x-fieldset.field>
            </x-fieldset.field-group>
        </x-fieldset>

        <x-fieldset.controls>
            <x-button type="button" wire:click="submit" color="primary">Submit</x-button>
            <x-button type="button" wire:click="dismiss">Cancel</x-button>
        </x-fieldset.controls>
    </x-form>
</x-modal>
