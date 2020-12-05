<x-form :action="route('settings.update')" method="PUT" id="characters">
    <x-form.section title="Character Limits" message="You can define how many characters a user is allowed to create for themselves. Additional characters beyond the limit can still be created, but will require GM approval to be activated.">
        <x-input.group>
            <x-input.toggle field="active" :value="old('active', '')">
                Enforce character limits
            </x-input.toggle>
        </x-input.group>

        <x-input.group label="Character Limit">
            <div class="w-full | sm:w-2/3">
                <x-input.number id="character_limit" name="character_limit" :value="old('character_limit', 5)" />
            </div>
        </x-input.group>
    </x-form.section>

    <x-form.section title="Automatic Position Availability" message="You can pick which character statuses will trigger Nova to automatically increment/decrement position availability. If none are selected, you will need to manage the availability of positions manually.">
        <x-input.group for="foo[]">
            <div class="block">
                <x-input.checkbox label="Primary characters" id="primary" value="Nova\Characters\Models\States\Statuses\Primary" for="primary" name="foo[]" />
            </div>
            <div class="block my-2">
                <x-input.checkbox label="Secondary characters" id="secondary" value="Nova\Characters\Models\States\Statuses\Secondary" for="secondary" name="foo[]" />
            </div>
            <div class="block">
                <x-input.checkbox label="Support characters" id="support" value="Nova\Characters\Models\States\Statuses\Support" for="support" name="foo[]" />
            </div>
        </x-input.group>
    </x-form.section>

    <x-form.footer>
        <x-button type="submit" form="defaults" color="blue">Update Character Settings</x-button>
    </x-form.footer>
</x-form>
