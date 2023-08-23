@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit rank group">
            <x-slot name="actions">
                @can('viewAny', $group::class)
                    <x-button.text :href="route('ranks.groups.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
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

                <x-input.group>
                    <x-switch-toggle
                        name="status"
                        :value="old('status', $group->status ?? 'active')"
                        on-value="active"
                        off-value="inactive"
                    >
                        Active
                    </x-switch-toggle>
                </x-input.group>
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
                                <x-button.text
                                    :href="route('ranks.items.edit', $rank)"
                                    color="gray"
                                    class="group-hover:visible sm:invisible"
                                >
                                    <x-icon name="edit" size="sm"></x-icon>
                                </x-button.text>
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
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.filled :href="route('ranks.groups.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
