@extends($meta->template)

@section('content')
<x-page-header title="Character Settings">
    <x-slot name="controls">
        <x-button color="white" size="sm" onclick="Livewire.emit('openModal', 'settings:find-settings')">
            @icon('search', 'h-5 w-5')
            <span class="ml-2">Find a setting</span>
        </x-button>
    </x-slot>
</x-page-header>

<x-panel>
    <x-form
        :action="route('settings.update', $tab)"
        method="PUT"
        id="character"
    >
        <x-form.section title="Character Creation">
            <x-slot name="message">
                <p>Change how character creation is handled for users who do not have the Create Character permission.</p>

                <p class="block"><strong class="font-semibold">Note:</strong> users with the Create Character permission will always be able to create characters regardless of these settings.</p>
            </x-slot>

            <x-input.group>
                <x-input.toggle
                    field="allow_character_creation"
                    :value="old('allow_character_creation', 'true')"
                >
                    Allow users to create characters
                </x-input.toggle>
            </x-input.group>

            <x-input.group>
                <x-input.toggle field="auto_link_character" :value="old('auto_link_character', 'true')">
                    Automatically link characters to the creating user
                </x-input.toggle>
            </x-input.group>

            <x-input.group>
                <x-input.toggle
                    field="require_approval_for_character_creation"
                    :value="old('require_approval_for_character_creation', 'true')"
                >
                    Require approval for created characters
                </x-input.toggle>
            </x-input.group>
        </x-form.section>

        <x-form.section title="Character Limits" message="Define how many characters a user can have linked to their account. Additional characters beyond the limit can still be created, but will require GM approval to be activated.">
            <x-input.group>
                <x-input.toggle field="enforce_character_limits" :value="old('enforce_character_limits', 'true')">
                    Enforce character limits
                </x-input.toggle>
            </x-input.group>

            <x-input.group label="Character Limit">
                <div class="w-full | sm:w-2/3 md:w-2/5">
                    <x-input.number id="character_limit" name="character_limit" :value="old('character_limit', 5)" />
                </div>
            </x-input.group>
        </x-form.section>

        <x-form.section title="Automatic Position Availability" message="You can pick which character statuses will trigger Nova to automatically update position availability. If none are selected, you will need to manage the availability of positions manually.">
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
            <x-button type="submit" form="character" color="blue">Update</x-button>
        </x-form.footer>
    </x-form>
</x-panel>
@endsection
