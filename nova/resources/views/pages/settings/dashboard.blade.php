@use('Nova\Settings\Enums\LeaderboardTimeframe')
@use('Nova\Settings\Enums\PostingTarget')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="actions">
                <x-button.find-setting />
            </x-slot>
        </x-page-heading>

        <x-form :action="route('admin.settings.dashboard.update')" method="PUT">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <div>
                        <x-button :href="route('admin.dashboard')">
                            Visit dashboard
                            <span aria-hidden="true">→</span>
                        </x-button>
                    </div>

                    <x-select
                        label="Calculate milestones based on"
                        description="Choose whether you’d like to have the posting milestones widget calculate based on posts or post words."
                        name="milestonesTarget"
                    >
                        @foreach (PostingTarget::cases() as $target)
                            <option value="{{ $target->value }}" @selected($target === $settings->milestonesTarget)>
                                {{ $target->getLabel() }}
                            </option>
                        @endforeach
                    </x-select>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::Award" heading="Contributions list">
                    <x-description>
                        Update how you’d like the contributions list to be calculated and displayed.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-switch
                        label="Enabled"
                        description="Enable a listing for posting contributions that can be customized to what you want to highlight"
                        name="leaderboard[enabled]"
                        :checked="old('leaderboard[enabled]', $settings->leaderboard->enabled)"
                    ></x-switch>

                    <x-input
                        label="Title"
                        name="leaderboard[title]"
                        :value="old('leaderboard[title]', $settings->leaderboard->title)"
                    />

                    <x-field>
                        <x-label>Icon</x-label>
                        <div>
                            <livewire:icon-picker
                                field="leaderboard[icon]"
                                :selected="old('leaderboard[icon]', $settings->leaderboard->icon->value)"
                            />
                        </div>
                    </x-field>

                    <x-switch
                        label="Only show active users"
                        description="Only calculate contributions based on users who are currently active"
                        name="leaderboard[onlyActiveUsers]"
                        :checked="old('leaderboard[onlyActiveUsers]', $settings->leaderboard->onlyActiveUsers)"
                    ></x-switch>

                    <x-select
                        label="Calculate contributions based on"
                        description="Choose whether you’d like to have the contributions widget calculate based on posts or post words."
                        name="leaderboard[target]"
                    >
                        @foreach (PostingTarget::cases() as $target)
                            <option
                                value="{{ $target->value }}"
                                @selected($target === $settings->leaderboard->target)
                            >
                                {{ $target->getLabel() }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-switch
                        label="Allow users to change the timeframe"
                        description="Give users the ability to change the timeframe used for measuring contribution stats"
                        name="leaderboard[userSelectableTimeframe]"
                        :checked="old('leaderboard[userSelectableTimeframe]', $settings->leaderboard->userSelectableTimeframe)"
                    ></x-switch>

                    <x-select
                        label="Timeframe"
                        description="Choose what timeframe you’d like to use for contribution stats"
                        name="leaderboard[timeframe]"
                    >
                        @foreach (LeaderboardTimeframe::cases() as $timeframe)
                            <option
                                value="{{ $timeframe->value }}"
                                @selected($timeframe === $settings->leaderboard->timeframe)
                            >
                                {{ $timeframe->getLabel() }}
                            </option>
                        @endforeach
                    </x-select>

                    <div class="w-full sm:w-1/2">
                        <x-input.number
                            label="Number of spots to show"
                            description="To show all users, set the number to zero"
                            name="leaderboard[numberOfSpotsToShow]"
                            :value="old('leaderboard[numberOfSpotsToShow]', $settings->leaderboard->numberOfSpotsToShow)"
                        />
                    </div>

                    <x-switch
                        label="Show rank numbers"
                        description="Show numbers next to users that correspond to their placement on the list"
                        name="leaderboard[showRankNumbers]"
                        :checked="old('leaderboard[showRankNumbers]', $settings->leaderboard->showRankNumbers)"
                    ></x-switch>

                    <x-switch
                        label="Hide users with no data"
                        description="Don’t show users with no available data"
                        name="leaderboard[hideUsersWithZero]"
                        :checked="old('leaderboard[hideUsersWithZero]', $settings->leaderboard->hideUsersWithZero)"
                    ></x-switch>

                    <x-switch
                        label="Show podium"
                        description="Show a podium representation for the top 3 posting contributors"
                        name="leaderboard[showPodium]"
                        :checked="old('leaderboard[showPodium]', $settings->leaderboard->showPodium)"
                    ></x-switch>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
