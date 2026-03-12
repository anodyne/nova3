@use('Nova\Announcements\Models\Announcement')
@use('Nova\Foundation\Enums\PublishStatus')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', Announcement::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.announcements.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <x-form :action="route('admin.announcements.store')">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input label="Title" name="title" :value="old('title')" />

                    <flux:autocomplete
                        label="Category"
                        description="You can select any existing category that you’ve used in the past, or you can create a new category."
                        name="category"
                        :value="old('category')"
                    >
                        @foreach ($categories as $category)
                            <flux:autocomplete.item>{{ $category }}</flux:autocomplete.item>
                        @endforeach
                    </flux:autocomplete>

                    <x-radio.group label="Status" name="status" variant="segmented" class="max-w-fit">
                        @foreach (PublishStatus::options() as $status)
                            <x-radio
                                :label="$status->getLabel()"
                                value="{{ $status->value }}"
                                :checked="old('status', 'draft') === $status->value"
                            />
                        @endforeach
                    </x-radio.group>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-editor name="content" :value="old('content')"></x-editor>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button :href="route('admin.announcements.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
