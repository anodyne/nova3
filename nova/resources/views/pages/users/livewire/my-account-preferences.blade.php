<div class="divide-y divide-gray-100 dark:divide-gray-800">
    <x-form.section
        title="User info"
        message="For privacy reasons, we don't recommend using your real name. Instead, use a nickname to help protect your identity."
    >
        <x-input.group label="Timezone" for="timezone" :error="$errors->first('form.timezone')">
            <x-input.text wire:model.live.debounce="form.timezone" />
        </x-input.group>
    </x-form.section>

    <x-form.footer>
        <x-button.filled type="button" wire:click="save" color="primary">Update</x-button.filled>
    </x-form.footer>
</div>
