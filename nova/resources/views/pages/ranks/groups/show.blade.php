@extends($meta->template)

@section('content')
    <x-page-header :title="$group->name">
        <x-slot:pretitle>
            <a href="{{ route('ranks.groups.index') }}">Rank Groups</a>
        </x-slot:pretitle>

        <x-slot:controls>
            @can('update', $group)
                <x-link :href="route('ranks.groups.edit', $group)" color="primary">Edit Rank Group</x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    <x-panel>
        <x-form action="">
            <x-form.section title="Rank Group Info" message="A rank group is a collection of ranks that can be assigned to characters. We group ranks to make it easier to find the ranks that you need.">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $group->name }}</p>
                </x-input.group>

                <x-input.group label="Status">
                    <x-badge :color="$group->status->color()">{{ $group->status->displayName() }}</x-badge>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Assigned Ranks" message="These are the ranks that have been assigned to this group.">
                <div class="flex flex-col w-full">
                    @foreach ($group->ranks as $rank)
                        <div class="group flex items-center justify-between py-2 px-4 rounded odd:bg-gray-100 dark:odd:bg-gray-700/50">
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <div class="flex items-center space-x-3">
                                    <x-status :status="$rank->status"></x-status>
                                    <x-rank :rank="$rank" />
                                </div>
                                <span class="font-medium text-sm ml-3">{{ $rank->name?->name }}</span>
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
                <x-link :href="route('ranks.groups.index')" color="white">Back</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
