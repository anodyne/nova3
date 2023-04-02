@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit rank group">
            <x-slot:actions>
                @can('viewAny', $group::class)
                    <x-link :href="route('ranks.groups.index')" leading="arrow-left" size="none" color="gray-text">
                        Back
                    </x-link>
                @endcan
            </x-slot:actions>
        </x-panel.header>

        <x-form :action="route('ranks.groups.update', $group)" method="PUT">
            <x-form.section title="Rank Group Info" message="A rank group is a collection of ranks that can be assigned to characters. We group ranks to make it easier to find the ranks that you need.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $group->name)" data-cy="name" />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="status"
                        :value="old('status', $group->status ?? 'active')"
                        active-value="active"
                        inactive-value="inactive"
                    >
                        Active
                    </x-input.toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Assigned Ranks" message="These are the ranks that have been assigned to this group.">
                <div class="flex flex-col w-full">
                    @foreach ($group->ranks as $rank)
                        <div class="group flex items-center justify-between py-2 px-4 rounded odd:bg-gray-50">
                            <div class="flex items-center">
                                <x-rank :rank="$rank" />
                                <span class="font-medium text-sm ml-3">{{ optional($rank->name)->name }}</span>
                            </div>
                            @can('update', $rank)
                                <a href="{{ route('ranks.items.edit', $rank) }}" class="text-gray-600 transition ease-in-out duration-200 hover:text-gray-900 group-hover:visible sm:invisible">
                                    @icon('edit')
                                </a>
                            @endcan
                        </div>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
                <x-link :href="route('ranks.groups.index')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
