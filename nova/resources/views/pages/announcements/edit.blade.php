@use('Nova\Announcements\Models\Announcement')
@use('Nova\Foundation\Enums\PublishStatus')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', Announcement::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.announcements.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.announcements.update', $announcement)" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Title" id="title" name="title" :error="$errors->first('title')">
                        <x-input.text :value="old('title', $announcement->title)" data-cy="title" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Category"
                        description="You can select any existing category that you’ve used in the past, or you can create a new category."
                        id="category"
                        name="category"
                        :error="$errors->first('category')"
                    >
                        <div data-slot="control">
                            <flux:autocomplete name="category" value="{{ old('category', $announcement->category) }}">
                                @foreach ($categories as $category)
                                    <flux:autocomplete.item>{{ $category }}</flux:autocomplete.item>
                                @endforeach
                            </flux:autocomplete>
                        </div>
                    </x-fieldset.field>

                    <x-fieldset.field label="Status" id="status" name="status" :error="$errors->first('status')">
                        <x-select>
                            <option value="">Choose a status</option>
                            @foreach (PublishStatus::options(withPending: $announcement->status === PublishStatus::Pending) as $status)
                                <option
                                    value="{{ $status->value }}"
                                    @selected($status->value === old('status', $announcement->status->value))
                                >
                                    {{ $status->getLabel() }}
                                </option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-fieldset.field id="content" name="content" :error="$errors->first('editor-content')">
                    <x-editor :value="old('editor-content', $announcement->content)"></x-editor>
                </x-fieldset.field>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('admin.announcements.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
