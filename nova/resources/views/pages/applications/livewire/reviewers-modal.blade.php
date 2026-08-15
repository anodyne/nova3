<x-modal :size-class="$this->sizeClass()" title="Manage application reviewers" :icon="Tabler::Users">
    <x-checkbox.group wire:model="selectedReviewers">
        @foreach ($users as $user)
            <x-checkbox :value="$user->id" :label="$user->name" />
        @endforeach
    </x-checkbox.group>

    <x-slot name="footer">
        <x-button type="button" wire:click="save" variant="primary">Update</x-button>
        <x-button type="button" wire:click="close" variant="ghost" :loading="false">Cancel</x-button>
    </x-slot>
</x-modal>
