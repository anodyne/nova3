@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit rank group">
            <x-slot name="actions">
                @can('viewAny', $group::class)
                    <x-button :href="route('ranks.groups.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('ranks.groups.update', $group)" method="PUT">
            <x-form.section
                title="Rank group info"
                message="A rank group is a collection of ranks that can be assigned to characters. We group ranks to make it easier to find the ranks that you need."
            >
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $group->name)" data-cy="name" />
                </x-input.group>

                <div class="flex items-center gap-x-2.5">
                    <x-switch
                        name="status"
                        :value="old('status', $group->status->value ?? 'active')"
                        on-value="active"
                        off-value="inactive"
                        id="status"
                    ></x-switch>
                    <x-fieldset.label for="status">Active</x-fieldset.label>
                </div>
            </x-form.section>

            <x-form.section title="Assigned ranks" message="These are the ranks that have been assigned to this group.">
                <div class="flex w-full flex-col">
                    @forelse ($group->ranks as $rank)
                        <div
                            class="group flex items-center justify-between rounded px-4 py-2 odd:bg-gray-100 dark:odd:bg-gray-700/50"
                        >
                            <div class="flex items-center">
                                <div class="flex items-center gap-2">
                                    <x-status :status="$rank->status"></x-status>
                                    <x-rank :rank="$rank"></x-rank>
                                </div>
                                <span class="ml-3 text-sm font-medium text-gray-600 dark:text-gray-300">
                                    {{ $rank->name?->name }}
                                </span>
                            </div>

                            @can('update', $rank)
                                <x-button
                                    :href="route('ranks.items.edit', $rank)"
                                    color="neutral"
                                    class="group-hover:visible sm:invisible"
                                    text
                                >
                                    <x-icon name="edit" size="sm"></x-icon>
                                </x-button>
                            @endcan
                        </div>
                    @empty
                        <x-empty-state.small
                            icon="list"
                            title="No ranks found for this rank group"
                            :link="route('ranks.items.create')"
                            :link-access="gate()->allows('create', Nova\Ranks\Models\RankItem::class)"
                            label="Add a rank item"
                        ></x-empty-state.small>
                    @endforelse
                </div>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('ranks.groups.index')" plain>Cancel</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
