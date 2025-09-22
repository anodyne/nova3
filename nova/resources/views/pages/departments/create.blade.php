@use('Nova\Departments\Models\Department')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', Department::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.departments.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.departments.store')">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input label="Name" name="name" :value="old('name')" />

                    <x-textarea label="Description" name="description" rows="5">
                        {{ old('description') }}
                    </x-textarea>

                    <x-switch label="Active" name="status" :checked="old('status')" align="left" />

                    <x-textarea
                        label="Tags"
                        description="A comma-separated list of tags that can be used for organizing your manifest(s)"
                        name="tags"
                        rows="2"
                    >
                        {{ old('tags') }}
                    </x-textarea>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.heading :icon="Tabler::Photo" heading="Header image">
                    <x-description>
                        Header images are used on the public-facing site to give you more control over the look and feel
                        of your manifest. Header images should be 4 times larger than the size you want to display it at
                        (for high resolution displays), but not more than 5MB in size.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <livewire:media-upload-image />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button :href="route('admin.departments.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
