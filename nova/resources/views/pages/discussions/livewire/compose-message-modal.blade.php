<x-modal :icon="$isReplying ? 'message-reply' : 'message'" :title="$isReplying ? 'Reply' : 'New message'">
    <x-form action="">
        <x-fieldset>
            <x-fieldset.field-group>
                @if (! $isReplying)
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

                <x-fieldset.field label="Subject" id="subject" name="subject">
                    @if ($isReplying)
                        <x-text>{{ $subject }}</x-text>
                    @else
                        <x-input.text wire:model.live.debounce.500ms="subject"></x-input.text>
                    @endif
                </x-fieldset.field>

                <x-fieldset.field label="Message" id="message" name="message">
                    <x-input.textarea rows="7" wire:model.live.debounce.500ms="content"></x-input.textarea>
                </x-fieldset.field>
            </x-fieldset.field-group>
        </x-fieldset>
    </x-form>

    <x-slot name="footer">
        @if ($isReplying)
            <x-button type="button" wire:click="reply" color="primary">Reply</x-button>
        @else
            <x-button type="button" wire:click="submit" color="primary">Submit</x-button>
        @endif

        <x-button type="button" wire:click="close" plain>Cancel</x-button>
    </x-slot>
</x-modal>
