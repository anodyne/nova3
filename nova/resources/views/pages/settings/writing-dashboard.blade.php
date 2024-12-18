@use('Nova\Settings\Enums\LeaderboardTimeframe')
@use('Nova\Settings\Enums\PostingTarget')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                <div x-data="{}">
                    <x-button x-on:click="$dispatch('toggle-spotlight')" color="neutral">
                        <x-icon name="search" size="sm"></x-icon>
                        Find a setting
                    </x-button>
                </div>
            </x-slot>
        </x-page-header>

        <x-form :action="route('admin.settings.writing-dashboard.update')" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <div>
                        <x-button :href="route('admin.writing-overview')">Go to dashboard &rarr;</x-button>
                    </div>

                    <x-fieldset.field
                        label="Calculate milestones based on"
                        description="Choose whether you’d like to have the posting milestones widget calculate based on posts or post words."
                        name="milestonesTarget"
                    >
                        <x-select>
                            @foreach (PostingTarget::cases() as $target)
                                <option
                                    value="{{ $target->value }}"
                                    @selected($target === $settings->milestonesTarget)
                                >
                                    {{ $target->getLabel() }}
                                </option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading>
                    <x-icon name="award"></x-icon>
                    <x-fieldset.legend>Contributions list</x-fieldset.legend>
                    <x-fieldset.description>
                        Update how you’d like the contributions list to be calculated and displayed.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-switch.group>
                        <x-switch.field>
                            <x-fieldset.label for="leaderboard_enabled">Enabled</x-fieldset.label>
                            <x-fieldset.description>
                                Enable a listing for posting contributions that can be customized to what you want to
                                highlight.
                            </x-fieldset.description>
                            <x-switch
                                name="leaderboard[enabled]"
                                :value="old('leaderboard[enabled]', $settings->leaderboard->enabled)"
                                id="leaderboard_enabled"
                            ></x-switch>
                        </x-switch.field>
                    </x-switch.group>

                    <x-fieldset.field label="Title" name="leaderboard[title]">
                        <x-input.text :value="old('leaderboard[title]', $settings->leaderboard->title)" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Icon"
                        description="You have access to the full Tabler icon set for this icon"
                        name="leaderboard[icon]"
                    >
                        <x-input.text :value="old('leaderboard[icon]', $settings->leaderboard->icon)" />
                    </x-fieldset.field>

                    <x-switch.group>
                        <x-switch.field>
                            <x-fieldset.label for="leaderboard_only_show_active_users">
                                Only show active users
                            </x-fieldset.label>
                            <x-fieldset.description>
                                Only calculate contributions based on users who are currently active.
                            </x-fieldset.description>
                            <x-switch
                                name="leaderboard[onlyActiveUsers]"
                                :value="old('leaderboard[onlyActiveUsers]', $settings->leaderboard->onlyActiveUsers)"
                                id="leaderboard_only_show_active_users"
                            ></x-switch>
                        </x-switch.field>
                    </x-switch.group>

                    <x-fieldset.field
                        label="Calculate contributions based on"
                        description="Choose whether you’d like to have the contributions widget calculate based on posts or post words."
                        name="leaderboard[target]"
                    >
                        <x-select>
                            @foreach (PostingTarget::cases() as $target)
                                <option
                                    value="{{ $target->value }}"
                                    @selected($target === $settings->leaderboard->target)
                                >
                                    {{ $target->getLabel() }}
                                </option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>

                    <x-switch.group>
                        <x-switch.field>
                            <x-fieldset.label for="leaderboard_user_selectable_timeframe">
                                Allow users to change the timeframe
                            </x-fieldset.label>
                            <x-fieldset.description>
                                Give users the ability to change the timeframe used for measuring contribution stats.
                            </x-fieldset.description>
                            <x-switch
                                name="leaderboard[userSelectableTimeframe]"
                                :value="old('leaderboard[userSelectableTimeframe]', $settings->leaderboard->userSelectableTimeframe)"
                                id="leaderboard_user_selectable_timeframe"
                            ></x-switch>
                        </x-switch.field>
                    </x-switch.group>

                    <x-fieldset.field
                        label="Timeframe"
                        description="Choose what timeframe you’d like to use for contribution stats"
                        name="leaderboard[timeframe]"
                    >
                        <x-select>
                            @foreach (LeaderboardTimeframe::cases() as $timeframe)
                                <option
                                    value="{{ $timeframe->value }}"
                                    @selected($timeframe === $settings->leaderboard->timeframe)
                                >
                                    {{ $timeframe->getLabel() }}
                                </option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Number of spots to show"
                        description="To show all users, set the number to zero"
                        name="leaderboard[numberOfSpotsToShow]"
                    >
                        <x-input.number
                            :value="old('leaderboard[numberOfSpotsToShow]', $settings->leaderboard->numberOfSpotsToShow)"
                            class="w-full sm:w-1/3"
                        ></x-input.number>
                    </x-fieldset.field>

                    <x-switch.group>
                        <x-switch.field>
                            <x-fieldset.label for="leaderboard_show_rank_numbers">Show rank numbers</x-fieldset.label>
                            <x-fieldset.description>
                                Show numbers next to users that correspond to their placement on the list.
                            </x-fieldset.description>
                            <x-switch
                                name="leaderboard[showRankNumbers]"
                                :value="old('leaderboard[showRankNumbers]', $settings->leaderboard->showRankNumbers)"
                                id="leaderboard_show_rank_numbers"
                            ></x-switch>
                        </x-switch.field>
                    </x-switch.group>

                    <x-switch.group>
                        <x-switch.field>
                            <x-fieldset.label for="leaderboard_hide_users_with_no_data">
                                Hide users with no data
                            </x-fieldset.label>
                            <x-fieldset.description>Don’t show users with no available data.</x-fieldset.description>
                            <x-switch
                                name="leaderboard[hideUsersWithZero]"
                                :value="old('leaderboard[hideUsersWithZero]', $settings->leaderboard->hideUsersWithZero)"
                                id="leaderboard_hide_users_with_no_data"
                            ></x-switch>
                        </x-switch.field>
                    </x-switch.group>

                    <x-switch.group>
                        <x-switch.field>
                            <x-fieldset.label for="leaderboard_show_podium">Show podium</x-fieldset.label>
                            <x-fieldset.description>
                                Show a podium representation for the top 3 posting contributors.
                            </x-fieldset.description>
                            <x-switch
                                name="leaderboard[showPodium]"
                                :value="old('leaderboard[showPodium]', $settings->leaderboard->showPodium)"
                                id="leaderboard_show_podium"
                            ></x-switch>
                        </x-switch.field>
                    </x-switch.group>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
