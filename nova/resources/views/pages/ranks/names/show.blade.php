@extends($meta->template)

@section('content')
    <x-page-header :title="$name->name">
        <x-slot:pretitle>
            <a href="{{ route('ranks.names.index') }}">Rank Names</a>
        </x-slot:pretitle>

        <x-slot:controls>
            @can('update', $name)
                <x-link :href="route('ranks.names.edit', $name)" color="blue">Edit Rank Name</x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    <x-panel>
        <x-form action="">
            <x-form.section title="Rank Name Info" message="Rank names allow you to re-use basic rank information across all of your ranks to avoid unnecessary and tedious editing of the same information across every rank in the system.">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $name->name }}</p>
                </x-input.group>

                <x-input.group label="Status">
                    <x-badge :color="$name->status->color()">{{ $name->status->displayName() }}</x-badge>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Assigned Ranks" message="These are the rank items that have been assigned this rank name.">
                <div class="flex flex-col w-full">
                    @foreach ($name->ranks as $rank)
                        <div class="group flex items-center justify-between py-2 px-4 rounded odd:bg-gray-100 dark:odd:bg-gray-700/50">
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <div class="flex items-center space-x-3">
                                    <x-status :status="$rank->status"></x-status>
                                    <x-rank :rank="$rank" />
                                </div>
                                <span class="font-medium ml-3">{{ $rank->group?->name }}</span>
                            </div>
                            @can('update', $rank)
                                <x-link :href="route('ranks.items.edit', $rank)" color="gray-text" size="none" class="group-hover:visible sm:invisible">
                                    @icon('edit')
                                </x-link>
                            @endcan
                        </div>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.footer>
                <x-link :href="route('ranks.names.index')" color="white">Back</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
