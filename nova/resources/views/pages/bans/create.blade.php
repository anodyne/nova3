@use('Nova\Users\Models\Ban')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', Ban::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.bans.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <x-form :action="route('admin.bans.store')" x-data="{ type: null }">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-radio.group class="flex-col" variant="cards" :indicator="false" x-model="type">
                        <x-radio
                            value="user"
                            label="Ban user"
                            description="Ban an existing user account from accessing the site"
                        >
                            <x-slot name="icon">
                                <x-icon :name="Tabler::UserOff" size="lg" />
                            </x-slot>
                        </x-radio>

                        <x-radio
                            value="ip"
                            label="Ban IP address"
                            description="Ban an IP address from accessing the site"
                        >
                            <x-slot name="icon">
                                <x-icon :name="Tabler::Network" size="lg" />
                            </x-slot>
                        </x-radio>
                    </x-radio.group>
                </x-fieldset.group>

                <x-fieldset.group constrained x-show="type === 'user'" x-cloak>
                    <x-select label="User" name="bannable_id">
                        <option value="">Choose a user to ban</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected($user->id === old('bannable_id'))>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </x-select>
                </x-fieldset.group>

                <x-fieldset.group constrained x-show="type === 'ip'" x-cloak>
                    <x-input
                        label="IP address"
                        description="IP address bans can be effective as a short-term solution with automated attacks on your site, but you may find that they are not terribly effective as a long-term solution due to rotating IPs and access to VPNs"
                        name="ip"
                        :value="old('ip')"
                    />
                </x-fieldset.group>

                <x-fieldset.group constrained x-show="type !== null" x-cloak>
                    <x-input.date
                        label="Expires at"
                        description="In order to automatically expire bans, you’ll need to setup a cron job to run at regular intervals that will delete expired bans. Otherwise, you’ll need to manually delete bans after they expire."
                        name="expired_at"
                        :value="old('expired_at')"
                    />

                    <x-textarea label="Comments" name="comment">{{ old('comment') }}</x-textarea>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls x-show="type !== null" x-cloak>
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button :href="route('admin.bans.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
