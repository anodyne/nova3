<x-admin-layout>
    <x-spacing constrained-lg>
        <x-page-header></x-page-header>

        <x-panel variant="well">
            <x-panel variant="inset">
                <div class="divide-y divide-gray-950/5 dark:divide-white/5">
                    @foreach ($characters as $character)
                        <livewire:characters-migrate-ranks :$character :key="$character->id" />
                    @endforeach
                </div>
            </x-panel>
        </x-panel>

        <div class="mt-4">
            {{ $characters->links() }}
        </div>
    </x-spacing>
</x-admin-layout>
