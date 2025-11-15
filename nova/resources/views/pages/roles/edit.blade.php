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

        <x-form :action="route('admin.roles.update', $role)" method="PUT">
            <x-fieldset>
                @if ($role->is_default)
                    <x-callout.warning heading="Warning" :icon="Tabler::AlertTriangle">
                        You’re editing a role that is given to every new user. Exercise caution when making changes to
                        this role.
                    </x-callout.warning>
                @endif

                <x-fieldset.group constrained>
                    <x-input label="Name" name="display_name" :value="old('display_name', $role->display_name)" />

                    <x-input label="Key" name="name" :value="old('name', $role->name)" />

                    <x-textarea label="Description" name="description" rows="3">
                        {{ old('description', $role->description) }}
                    </x-textarea>

                    <x-switch
                        label="Assign this role to new users"
                        name="is_default"
                        :checked="old('is_default', $role->is_default)"
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

                        <livewire:roles-manage-permissions :$role />
                    </x-field>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header>
                        <x-slot name="title">
                            <div class="flex items-center gap-2">
                                Users with this role
                                <x-badge color="primary" type="square">{{ $role->user_count }}</x-badge>
                            </div>
                        </x-slot>
                    </x-panel.header>

                    <livewire:roles-manage-users :role="$role" />
                </x-panel>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.roles.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
