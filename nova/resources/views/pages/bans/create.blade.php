@use('Nova\Users\Models\Ban')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', Ban::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.bans.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.bans.store')" x-data="{ type: null }">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <flux:radio.group class="flex-col" variant="cards" :indicator="false" x-model="type">
                        <flux:radio
                            value="user"
                            label="Ban user"
                            description="Ban an existing user account from accessing the site"
                        >
                            <x-slot name="icon">
                                <x-icon name="user-off" size="lg"></x-icon>
                            </x-slot>
                        </flux:radio>

                        <flux:radio
                            value="ip"
                            label="Ban IP address"
                            description="Ban an IP address from accessing the site"
                        >
                            <x-slot name="icon">
                                <x-icon name="network" size="lg"></x-icon>
                            </x-slot>
                        </flux:radio>
                    </flux:radio.group>
                </x-fieldset.field-group>

                <x-fieldset.field-group constrained x-show="type === 'user'" x-cloak>
                    <x-fieldset.field
                        label="User"
                        id="bannable_id"
                        name="bannable_id"
                        :error="$errors->first('bannable_id')"
                    >
                        <x-select>
                            <option value="">Choose a user to ban</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" @selected($user->id === old('bannable_id'))>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>
                </x-fieldset.field-group>

                <x-fieldset.field-group constrained x-show="type === 'ip'" x-cloak>
                    <x-fieldset.field
                        label="IP address"
                        description="IP address bans can be effective as a short-term solution with automated attacks on your site, but you may find that they are not terribly effective as a long-term solution due to rotating IPs and access to VPNs"
                        id="ip"
                        name="ip"
                        :error="$errors->first('ip')"
                    >
                        <x-input.text :value="old('ip')" data-cy="ip" />
                    </x-fieldset.field>
                </x-fieldset.field-group>

                <x-fieldset.field-group constrained x-show="type !== null" x-cloak>
                    <x-fieldset.field
                        label="Expires at"
                        description="In order to automatically expire bans, you will need to setup a cron job to run at regular intervals that will delete expired bans"
                        id="expired_at"
                        name="expired_at"
                        :error="$errors->first('expired_at')"
                    >
                        <x-input.date :value="old('expired_at')"></x-input.date>
                    </x-fieldset.field>

                    <x-fieldset.field label="Comments" id="comment" name="comment" :error="$errors->first('comment')">
                        <x-input.textarea>{{ old('comment') }}</x-input.textarea>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls x-show="type !== null" x-cloak>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('admin.bans.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
