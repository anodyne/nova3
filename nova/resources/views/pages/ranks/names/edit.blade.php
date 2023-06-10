@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit rank name">
            <x-slot name="actions">
                @can('viewAny', Nova\Ranks\Models\RankName::class)
                    <x-button.text :href="route('ranks.names.index')" leading="arrow-left" color="gray">Back</x-button.text>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('ranks.names.update', $name)" method="PUT">
            <x-form.section title="Rank Name Info" message="Rank names allow you to re-use basic rank information across all of your ranks to avoid unnecessary and tedious editing of the same information across every rank in the system.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $name->name)" data-cy="name" />
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle name="status" :value="old('status', $name->status ?? 'active')" on-value="active" off-value="inactive">Active</x-switch-toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Assigned Ranks" message="These are the rank items that have been assigned this rank name.">
                <div class="flex w-full flex-col">
                    @foreach ($name->ranks as $rank)
                        <div class="group flex items-center justify-between rounded px-4 py-2 odd:bg-gray-100">
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <x-rank :rank="$rank" />
                                <span class="ml-3 font-medium">{{ optional($rank->group)->name }}</span>
                            </div>
                            @can('update', $rank)
                                <a href="{{ route('ranks.items.edit', $rank) }}" class="text-gray-500 transition duration-200 ease-in-out hover:text-gray-700 group-hover:visible sm:invisible">
                                    <x-icon name="edit" size="sm"></x-icon>
                                </a>
                            @endcan
                        </div>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.outline :href="route('ranks.names.index')" color="gray">Cancel</x-button.outline>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
