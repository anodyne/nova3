<x-content-box>
    <div class="grid grid-cols-3 gap-6">
        @forelse ($records as $record)
            <x-panel x-data="{ id: {{ $record->id ?? 0 }} }">
                <div class="shrink-0">
                    <img
                        class="h-48 w-full object-cover sm:rounded-t-lg"
                        src="{{ asset("themes/{$record->location}/{$record->preview}") }}"
                        alt=""
                    />
                </div>

                <x-content-box>
                    <div class="flex items-center justify-between">
                        <x-h3>{{ $record->name }}</x-h3>

                        <x-filament-tables::actions
                            :actions="$this->getTable()->getActions()"
                            :record="$record"
                        ></x-filament-tables::actions>
                    </div>
                    <p class="mt-1 flex items-center text-base text-gray-500">
                        <x-icon name="folder" size="sm" class="mr-2 shrink-0 text-gray-500"></x-icon>
                        themes/{{ $record->location }}
                    </p>
                    <div class="mt-2">
                        <x-badge :color="($record->exists) ? $record->status->color() : 'warning'">
                            {{ ($record->exists) ? $record->status->getLabel() : 'Pending' }}
                        </x-badge>
                    </div>
                </x-content-box>
            </x-panel>
        @empty
            <div>Nothing</div>
        @endforelse
    </div>
</x-content-box>
