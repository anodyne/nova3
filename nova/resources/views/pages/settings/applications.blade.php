@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header :$meta>
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" color="neutral">
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-page-header>

        <x-form :action="route('admin.settings.applications.update')" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-switch.group>
                        <x-switch.field>
                            <x-fieldset.label for="enabled">Applications enabled</x-fieldset.label>
                            <x-fieldset.description>Allow new players to apply to join the game</x-fieldset.description>
                            <x-switch
                                name="enabled"
                                :value="old('enabled', $settings->enabled ?? true)"
                                id="enabled"
                            ></x-switch>
                        </x-switch.field>

                        <x-switch.field>
                            <x-fieldset.label for="alwaysShowResults">Always show voting results</x-fieldset.label>
                            <x-fieldset.description>
                                Show the results of voting prior to a reviewer submitting their own vote
                            </x-fieldset.description>
                            <x-switch
                                name="alwaysShowResults"
                                :value="old('alwaysShowResults', $settings->alwaysShowResults ?? false)"
                                id="alwaysShowResults"
                            ></x-switch>
                        </x-switch.field>

                        <x-switch.field>
                            <x-fieldset.label for="allowVoteChanging">Allow vote changes</x-fieldset.label>
                            <x-fieldset.description>
                                Allow reviewers to update their vote after submitting
                            </x-fieldset.description>
                            <x-switch
                                name="allowVoteChanging"
                                :value="old('allowVoteChanging', $settings->allowVoteChanging ?? false)"
                                id="allowVoteChanging"
                            ></x-switch>
                        </x-switch.field>

                        <x-switch.field>
                            <x-fieldset.label for="allowVoteChanging">Show decision message</x-fieldset.label>
                            <x-fieldset.description>
                                Allow all reviewers to see the final decision message sent to the applicant
                            </x-fieldset.description>
                            <x-switch
                                name="showDecisionMessage"
                                :value="old('showDecisionMessage', $settings->showDecisionMessage ?? false)"
                                id="showDecisionMessage"
                            ></x-switch>
                        </x-switch.field>
                    </x-switch.group>
                </x-fieldset.field-group>

                <x-fieldset.field-group>
                    <x-fieldset.field
                        label="Disabled message"
                        description="This is the message users will see when applications are disabled"
                        id="disabled_message"
                        name="disabled_message"
                    >
                        <x-input.textarea rows="3">{{ $settings->disabledMessage }}</x-input.textarea>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="users"></x-icon>
                    <x-fieldset.legend>Reviewers</x-fieldset.legend>
                    <x-fieldset.description>
                        Control the users who are involved in reviewing new users and characters to join the game.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group>
                    <x-panel well>
                        <x-panel.well-heading
                            heading="Global reviewers"
                            description="Reviewers that are added to every new application"
                        ></x-panel.well-heading>

                        <x-spacing size="2xs">
                            <livewire:settings-manage-global-reviewers />
                        </x-spacing>

                        @if ($usersWithApprovePermissionsCount === 0)
                            <x-spacing width="sm" top="2xs" bottom="xs">
                                <x-fieldset.error-message>
                                    None of the global reviewers have permission to approve applications. Please make
                                    sure that at least one global reviewer has the
                                    <code class="font-semibold">application.approve</code>
                                    permission.
                                </x-fieldset.error-message>
                            </x-spacing>
                        @endif
                    </x-panel>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
