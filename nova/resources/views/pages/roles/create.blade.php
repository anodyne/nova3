@use('Nova\Roles\Models\Role')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', Role::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.roles.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <div
            x-data="{
                displayName: '{{ old('display_name') }}',
                name: '{{ old('name') }}',
                suggestName: true,
            }"
            x-init="
                $watch('displayName', (value) => {
                    if (suggestName) {
                        name = value
                            .toLowerCase()
                            .replace(/[^\w ]+/g, '')
                            .replace(/ +/g, '-')
                    }
                })
            "
        >
            <x-form :action="route('admin.roles.store')">
                <x-fieldset>
                    <x-fieldset.group constrained>
                        <x-input label="Name" name="display_name" x-model="displayName" />

                        <x-input label="Key" name="name" x-model="name" x-on:change="suggestName = false" />

                        <x-textarea label="Description" name="description" rows="3">
                            {{ old('description') }}
                        </x-textarea>

                        <x-switch
                            label="Assign this role to new users"
                            name="is_default"
                            :checked="old('is_default')"
                            align="left"
                        />
                    </x-fieldset.group>
                </x-fieldset>

                <x-fieldset>
                    <x-fieldset.group constrained>
                        <x-field>
                            <x-label>Permissions assigned to this role</x-label>
                            <x-description>
                                Our recommendation is to give roles as few permissions as possible and compose user
                                authorization from multiple roles
                            </x-description>

                            <livewire:roles-manage-permissions />
                        </x-field>
                    </x-fieldset.group>
                </x-fieldset>

                <x-fieldset>
                    <x-panel variant="well">
                        <x-panel.header title="Users with this role">
                            <x-slot name="description">
                                These users will be assigned this role and have all of the permissions listed below when
                                it’s created.
                            </x-slot>
                        </x-panel.header>

                        <livewire:roles-manage-users />
                    </x-panel>
                </x-fieldset>

                <x-fieldset.controls>
                    <x-button type="submit" variant="primary">Add</x-button>
                    <x-button :href="route('admin.roles.index')" variant="ghost">Cancel</x-button>
                </x-fieldset.controls>
            </x-form>
        </div>
    </x-spacing>
</x-admin-layout>
