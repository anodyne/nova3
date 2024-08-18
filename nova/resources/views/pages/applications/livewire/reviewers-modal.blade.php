<x-modal title="Manage application reviewers" icon="users">
    <x-form action="">
        <x-fieldset>
            <x-checkbox.group class="*:rounded-lg *:px-3 *:py-1 *:odd:bg-gray-50 *:dark:odd:bg-gray-700">
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

        <x-fieldset.controls>
            <x-button type="button" wire:click="save" color="primary">Update</x-button>
            <x-button type="button" wire:click="dismiss">Cancel</x-button>
        </x-fieldset.controls>
    </x-form>
</x-modal>
