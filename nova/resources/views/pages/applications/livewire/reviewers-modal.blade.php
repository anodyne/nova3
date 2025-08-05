<x-modal title="Manage application reviewers" :icon="Icon::Users">
    <x-form action="">
        <x-fieldset>
            <x-checkbox.group class="*:rounded-lg *:px-3 *:py-1 *:odd:bg-gray-950/[.04] *:dark:odd:bg-white/[.07]">
                @foreach ($users as $user)
                    <x-checkbox.field>
                        <x-checkbox
                            wire:model.live="selectedReviewers"
                            value="{{ $user->id }}"
                            id="user_{{ $user->id }}"
                        ></x-checkbox>
                        <x-fieldset.label for="user_{{ $user->id }}">{{ $user->name }}</x-fieldset.label>
                    </x-checkbox.field>
                @endforeach
            </x-checkbox.group>
        </x-fieldset>
    </x-form>

    <x-slot name="footer">
        <x-button type="button" wire:click="save" color="primary">Update</x-button>
        <x-button type="button" wire:click="close" plain>Cancel</x-button>
    </x-slot>
</x-modal>
