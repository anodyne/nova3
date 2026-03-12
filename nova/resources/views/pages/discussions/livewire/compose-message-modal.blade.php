<x-modal :icon="$isReplying ? Tabler::MessageReply : Tabler::Message" :title="$isReplying ? 'Reply' : 'New message'">
    <x-form action="">
        <x-fieldset>
            <x-fieldset.group>
                @if (! $isReplying)
                    <x-field>
                        <x-label>To</x-label>

                        <x-select name="to" wire:model.live="recipients" variant="listbox" multiple>
                            @foreach ($users as $user)
                                <x-select.option value="{{ $user->id }}">{{ $user->name }}</x-select.option>
                            @endforeach
                        </x-select>
                    </x-field>
                @endif

                <x-field>
                    <x-label>Subject</x-label>

                    @if ($isReplying)
                        <x-text>{{ $subject }}</x-text>
                    @else
                        <x-input name="subject" wire:model.live.debounce.500ms="subject" />
                    @endif
                </x-field>

                <x-textarea
                    label="Message"
                    name="message"
                    rows="7"
                    wire:model.live.debounce.500ms="content"
                ></x-textarea>
            </x-fieldset.group>
        </x-fieldset>
    </x-form>

    <x-slot name="footer">
        @if ($isReplying)
            <x-button type="button" wire:click="reply" variant="primary">Reply</x-button>
        @else
            <x-button type="button" wire:click="submit" variant="primary">Submit</x-button>
        @endif

        <x-button type="button" wire:click="close" variant="ghost">Cancel</x-button>
    </x-slot>
</x-modal>
