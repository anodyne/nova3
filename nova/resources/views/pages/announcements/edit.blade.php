@use('Nova\Announcements\Models\Announcement')
@use('Nova\Foundation\Enums\PublishStatus')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', Announcement::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.announcements.index')" variant="ghost" inset="right">
                        &larr; Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.announcements.update', $announcement)" method="PUT">
            <x-fieldset>
                <x-fieldset.fields constrained>
                    <x-input label="Title" name="title" :value="old('title', $announcement->title)" />

                    <flux:autocomplete
                        label="Category"
                        description="You can select any existing category that you’ve used in the past, or you can create a new category."
                        name="category"
                        :value="old('category', $announcement->category)"
                    >
                        @foreach ($categories as $category)
                            <flux:autocomplete.item>{{ $category }}</flux:autocomplete.item>
                        @endforeach
                    </flux:autocomplete>

                    <x-select label="Status" name="status">
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
                </x-fieldset.fields>
            </x-fieldset>

            <x-fieldset>
                <x-editor name="content" :value="old('content', $announcement->content)"></x-editor>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.announcements.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
