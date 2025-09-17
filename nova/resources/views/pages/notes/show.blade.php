<x-admin-layout>
    <x-spacing constrained>
        <x-page-header :heading="$note->title">
            <x-slot name="actions">
                <x-button :href="route('admin.notes.index')" variant="ghost">
                    <span aria-hidden="true">←</span>
                    Back
                </x-button>

                <x-button :href="route('admin.notes.edit', $note)" variant="primary">
                    <x-icon :name="Tabler::Pencil" size="sm" />
                    Edit
                </x-button>
            </x-slot>
        </x-page-header>

        <div class="prose dark:prose-invert max-w-none">
            {!! $note->content !!}
        </div>
    </x-spacing>
</x-admin-layout>
