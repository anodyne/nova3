@extends($meta->template)

@section('content')
    <x-page-header :title="$group->name">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.groups.index') }}">Rank Groups</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $group)
                <x-link :href="route('ranks.groups.edit', $group)" color="blue">Edit Rank Group</x-link>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form action="">
            <x-form.section title="Rank Group Info" message="A rank group is a collection of ranks that can be assigned to characters. We group ranks to make it easier to find the ranks that you need.">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $group->name }}</p>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Assigned Ranks" message="These are the ranks that have been assigned to this group.">
                <div class="flex flex-col w-full">
                    @foreach ($group->ranks as $rank)
                        <div class="group flex items-center justify-between py-2 px-4 rounded odd:bg-gray-2">
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <x-rank :rank="$rank" />
                                <span class="font-medium text-sm ml-3">{{ optional($rank->name)->name }}</span>
                            </div>
                            @can('update', $rank)
                                <a href="{{ route('ranks.items.edit', $rank) }}" class="text-gray-11 transition ease-in-out duration-200 hover:text-gray-12 group-hover:visible sm:invisible">
                                    @icon('edit')
                                </a>
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
