<div class="space-y-12" wire:key="account-preferences">
    <x-fieldset>
        <x-fieldset.field-group constrained>
            <x-fieldset.field label="Timezone" id="timezone" name="timezone" :error="$errors->first('form.timezone')">
                <x-input.text wire:model.live.debounce="form.timezone"></x-input.text>
            </x-fieldset.field>

            <x-switch.field>
                <x-fieldset.label>Dark mode</x-fieldset.label>
                <x-fieldset.description>Show the admin panel in dark mode</x-fieldset.description>
                <livewire:users-admin-theme-toggle />
            </x-switch.field>
        </x-fieldset.field-group>
    </x-fieldset>

    <x-fieldset.controls>
        <x-button type="button" wire:click="save" color="primary">Update</x-button>
    </x-fieldset.controls>
</div>
