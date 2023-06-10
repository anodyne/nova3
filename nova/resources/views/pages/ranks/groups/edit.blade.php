@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit rank group">
            <x-slot name="actions">
                @can('viewAny', $group::class)
                    <x-button.text :href="route('ranks.groups.index')" leading="arrow-left" color="gray">Back</x-button.text>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('ranks.groups.update', $group)" method="PUT">
            <x-form.section title="Rank Group Info" message="A rank group is a collection of ranks that can be assigned to characters. We group ranks to make it easier to find the ranks that you need.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $group->name)" data-cy="name" />
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle name="status" :value="old('status', $group->status ?? 'active')" on-value="active" off-value="inactive">Active</x-switch-toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Assigned Ranks" message="These are the ranks that have been assigned to this group.">
                <div class="flex w-full flex-col">
                    @foreach ($group->ranks as $rank)
                        <div class="group flex items-center justify-between rounded px-4 py-2 odd:bg-gray-50">
                            <div class="flex items-center">
                                <x-rank :rank="$rank" />
                                <span class="ml-3 text-sm font-medium">{{ optional($rank->name)->name }}</span>
                            </div>
                            @can('update', $rank)
                                <a href="{{ route('ranks.items.edit', $rank) }}" class="text-gray-600 transition duration-200 ease-in-out hover:text-gray-900 group-hover:visible sm:invisible">
                                    <x-icon name="edit" size="sm"></x-icon>
                                </a>
                            @endcan
                        </div>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.outline :href="route('ranks.groups.index')" color="gray">Cancel</x-button.outline>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
