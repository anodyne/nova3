@extends($meta->template)

@use('Nova\Roles\Models\Role')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Add a new role</x-slot>

            <x-slot name="actions">
                @can('viewAny', Role::class)
                    <x-button :href="route('admin.roles.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

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
                    <x-fieldset.field-group constrained>
                        <x-fieldset.field
                            label="Name"
                            id="display_name"
                            name="display_name"
                            :error="$errors->first('display_name')"
                        >
                            <x-input.text x-model="displayName" data-cy="display_name" />
                        </x-fieldset.field>

                        <x-fieldset.field label="Key" id="name" name="name" :error="$errors->first('name')">
                            <x-input.text x-model="name" x-on:change="suggestName = false" data-cy="name" />
                        </x-fieldset.field>

                        <x-fieldset.field label="Description" id="description" name="description">
                            <x-input.textarea data-cy="description" rows="3">
                                {{ old('description') }}
                            </x-input.textarea>
                        </x-fieldset.field>

                        <div class="flex items-center gap-x-2.5">
                            <x-switch name="is_default" :value="old('is_default')" id="is_default"></x-switch>
                            <x-fieldset.label for="is_default">Assign this role to new users</x-fieldset.label>
                        </div>
                    </x-fieldset.field-group>
                </x-fieldset>

                <x-fieldset>
                    <x-panel well>
                        <x-spacing size="sm">
                            <x-fieldset.legend>Permissions for this role</x-fieldset.legend>
                            <x-fieldset.description>
                                These permissions will be added to the role when it’s created.
                            </x-fieldset.description>
                        </x-spacing>

                        <x-spacing size="2xs">
                            <livewire:roles-manage-permissions />
                        </x-spacing>
                    </x-panel>
                </x-fieldset>

                <x-fieldset>
                    <x-panel well>
                        <x-spacing size="sm">
                            <x-fieldset.legend>Users with this role</x-fieldset.legend>
                            <x-fieldset.description>
                                These users will be assigned this role and have all of the permissions listed below when
                                it’s created.
                            </x-fieldset.description>
                        </x-spacing>

                        <x-spacing size="2xs">
                            <livewire:roles-manage-users />
                        </x-spacing>
                    </x-panel>
                </x-fieldset>

                <x-fieldset>
                    <div class="flex gap-x-2 lg:flex-row-reverse">
                        <x-button type="submit" color="primary">Add</x-button>
                        <x-button :href="route('admin.roles.index')" plain>Cancel</x-button>
                    </div>
                </x-fieldset>
            </x-form>
        </div>
    </x-spacing>
@endsection
