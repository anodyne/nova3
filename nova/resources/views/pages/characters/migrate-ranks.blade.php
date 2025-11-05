<x-admin-layout>
    <x-spacing constrained-lg>
        <x-page-heading></x-page-heading>

        <x-panel variant="well">
            <x-panel variant="inset">
                <x-spacing.group divided>
                    @foreach ($characters as $character)
                        <livewire:characters-migrate-ranks :$character :key="$character->id" />
                    @endforeach
                </x-spacing.group>
            </x-panel>
        </x-panel>

        <div class="mt-4">
            {{ $characters->links() }}
        </div>
    </x-spacing>
</x-admin-layout>
