@extends($meta->template)

@section('content')
    <x-panel
        x-data="{ displayName: '{{ old('display_name') }}', name: '{{ old('name') }}', suggestName: true }"
        x-init="$watch('displayName', value => {
            if (suggestName) {
                name = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
            }
        })"
    >
        <x-panel.header title="Add a new role">
            <x-slot name="actions">
                @can('viewAny', Nova\Roles\Models\Role::class)
                    <x-button.text :href="route('roles.index')" leading="arrow-left" color="gray">Back</x-button.text>
                @endcan
            </x-slot>
        </x-panel.header>

        @json($errors)

        <x-form :action="route('roles.store')">
            <x-form.section
                title="Role info"
                message="A role is a collection of permissions that allows a user to take certain actions throughout
            Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer
            permissions to give yourself more freedom to add and remove access for a given user."
            >
                <x-input.group label="Name" for="display_name" :error="$errors->first('display_name')">
                    <x-input.text x-model="displayName" id="display_name" name="display_name" data-cy="display_name" />
                </x-input.group>

                <x-input.group label="Key" for="name" :error="$errors->first('name')">
                    <x-input.text x-model="name" @change="suggestName = false" id="name" name="name" data-cy="name" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="3">
                        {{ old('description') }}
                    </x-input.textarea>
                </x-input.group>

                <div class="flex items-center gap-x-2.5">
                    <x-switch name="is_default" :value="old('is_default')" id="is_default"></x-switch>
                    <x-fieldset.label for="is_default">Assign this role to new users</x-fieldset.label>
                </div>
            </x-form.section>

            <x-form.section
                title="Permissions to assign to this role"
                message="These permissions will be assigned to this role."
            >
                <livewire:roles-manage-permissions />
            </x-form.section>

            <x-form.section
                title="Users to assign to this role"
                message="These users will be assigned this role and have all of the permissions listed above."
            >
                <livewire:roles-manage-users />
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Add</x-button.filled>
                <x-button.filled :href="route('roles.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
