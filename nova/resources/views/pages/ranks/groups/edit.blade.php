@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$group->name">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.groups.index') }}">Rank Groups</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('ranks.groups.update', $group)" method="PUT">
            <x-form.section title="Rank Group Info" message="A rank group is a collection of ranks that can be assigned to characters. We group ranks to make it easier to find the ranks that you need.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $group->name)" data-cy="name" />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Assigned Ranks" message="These are the ranks that have been assigned to this group.">
                <div class="flex flex-col w-full">
                    @foreach ($group->ranks as $rank)
                        <div class="group flex items-center justify-between py-2 px-4 rounded even:bg-gray-100">
                            <div class="flex items-center">
                                <x-rank :base="$rank->base_image" :overlay="$rank->overlay_image" />
                                <span class="font-medium text-sm ml-3">{{ optional($rank->name)->name }}</span>
                            </div>
                            @can('update', $rank)
                                <a href="{{ route('ranks.items.edit', $rank) }}" class="text-gray-500 transition ease-in-out duration-150 hover:text-gray-700 group-hover:visible | sm:invisible">
                                    @icon('edit')
                                </a>
                            @endcan
                        </div>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Update Rank Group</button>

                <a href="{{ route('ranks.groups.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
