<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                <x-button.find-setting />
            </x-slot>
        </x-page-heading>

        <x-form :action="route('admin.settings.applications.update')" method="PUT">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-switch
                        label="Applications enabled"
                        description="Allow new players to apply to join the game"
                        name="enabled"
                        :checked="old('enabled', $settings->enabled)"
                    ></x-switch>

                    <x-switch
                        label="Always show voting results"
                        description="Show the results of voting prior to a reviewer submitting their own vote"
                        name="alwaysShowResults"
                        :checked="old('alwaysShowResults', $settings->alwaysShowResults ?? false)"
                    ></x-switch>

                    <x-switch
                        label="Allow vote changes"
                        description="Allow reviewers to update their vote after submitting"
                        name="allowVoteChanging"
                        :checked="old('allowVoteChanging', $settings->allowVoteChanging ?? false)"
                    ></x-switch>

                    <x-switch
                        label="Show decision message"
                        description="Allow all reviewers to see the final decision message sent to the applicant"
                        name="showDecisionMessage"
                        :checked="old('showDecisionMessage', $settings->showDecisionMessage ?? false)"
                    ></x-switch>
                </x-fieldset.group>

                <x-fieldset.group>
                    <x-textarea
                        label="Disabled message"
                        description="This is the message users will see when applications are disabled"
                        id="disabled_message"
                        name="disabled_message"
                        rows="3"
                    >
                        {{ $settings->disabledMessage }}
                    </x-textarea>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::Users" heading="Reviewers">
                    <x-description>
                        Control the users who are involved in reviewing new users and characters to join the game.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group>
                    <x-panel variant="well">
                        <x-panel.header
                            title="Global reviewers"
                            description="Reviewers that are added to every new application (in addition to users with the Approve Applications permission)"
                        ></x-panel.header>

                        <livewire:settings-manage-global-reviewers />

                        @if ($usersWithApprovePermissionsCount === 0)
                            <x-panel.footer>
                                <x-description.danger>
                                    None of the global reviewers have permission to approve applications. Please make
                                    sure that at least one global reviewer has the
                                    <code class="font-semibold">application.approve</code>
                                    permission.
                                </x-description.danger>
                            </x-panel.footer>
                        @endif
                    </x-panel>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
