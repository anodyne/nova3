@use('Nova\Announcements\Models\Announcement')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', Announcement::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.announcements.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.announcements.store')">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Title" id="title" name="title" :error="$errors->first('title')">
                        <x-input.text :value="old('title')" data-cy="title" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Category"
                        description="You can select any existing category that you’ve used in the past, or you can create a new category."
                        id="category"
                        name="category"
                        :error="$errors->first('category')"
                    >
                        <x-input.text :value="old('category')" list="categories" data-cy="category" />

                        <datalist id="categories">
                            @foreach ($categories as $category)
                                <option value="{{ $category }}"></option>
                            @endforeach
                        </datalist>
                    </x-fieldset.field>

                    <x-switch.group>
                        <x-switch.field>
                            <x-fieldset.label for="published">Published</x-fieldset.label>
                            <x-fieldset.description>
                                This announcement will be sent to all active users.
                            </x-fieldset.description>

                            <x-switch name="published" id="published" :value="old('published', true)"></x-switch>
                        </x-switch.field>
                    </x-switch.group>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.field id="content" name="content" :error="$errors->first('editor-content')">
                    <x-editor :value="old('editor-content', '')"></x-editor>
                </x-fieldset.field>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('admin.announcements.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
