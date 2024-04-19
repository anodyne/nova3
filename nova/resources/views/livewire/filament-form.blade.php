<div>
    <form wire:submit.prevent="save" class="space-y-12">
        <x-fieldset>
            {{ $this->form }}
        </x-fieldset>

        <x-fieldset.controls>
            <x-button type="submit" color="primary">Save</x-button>
        </x-fieldset.controls>
    </form>
</div>
