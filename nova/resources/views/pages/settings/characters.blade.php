@extends($meta->template)

@section('content')
    <x-page-header title="Character Settings" x-data="{}">
        <x-slot:controls>
            <x-button type="button" color="white" size="sm" @click="$dispatch('toggle-spotlight')">
                @icon('search', 'h-5 w-5')
                <span class="ml-2">Find a setting</span>
            </x-button>
        </x-slot:controls>
    </x-page-header>

    <x-panel>
        <x-form
            :action="route('settings.update', $tab)"
            method="PUT"
            id="character"
        >
            <x-form.section title="Character Creation">
                <x-slot:message>
                    <p>Change how character creation is handled for users who do not have the Create Character permission.</p>

                    <p class="block"><strong class="font-semibold">Note:</strong> users with the Create Character permission will always be able to create characters regardless of these settings.</p>
                </x-slot:message>

                <x-input.group>
                    <x-input.toggle
                        field="allow_character_creation"
                        :value="old('allow_character_creation', $settings->characters->allowCharacterCreation)"
                    >
                        Allow creating characters
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="auto_link_character" :value="old('auto_link_character', $settings->characters->autoLinkCharacter)">
                        Auto-link created character to the creating user
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="allow_setting_primary_character" :value="old('allow_setting_primary_character', $settings->characters->allowSettingPrimaryCharacter)" help="Requires auto-linking created characters to be enabled.">
                        Allow setting created character as a primary character
                    </x-input.toggle>

                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="require_approval_for_character_creation"
                        :value="old('require_approval_for_character_creation', $settings->characters->requireApprovalForCharacterCreation)"
                    >
                        Require approval for created characters
                    </x-input.toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Character Limits" message="Define how many characters a user can have linked to their account. Additional characters beyond the limit can still be created, but will require GM approval to be activated.">
                <x-input.group>
                    <x-input.toggle field="enforce_character_limits" :value="old('enforce_character_limits', $settings->characters->enforceCharacterLimits)">
                        Enforce character limits
                    </x-input.toggle>
                </x-input.group>

                <x-input.group label="Character Limit">
                    <div class="w-full sm:w-2/3 md:w-2/5">
                        <x-input.number id="character_limit" name="character_limit" :value="old('character_limit', $settings->characters->characterLimit)" />
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
