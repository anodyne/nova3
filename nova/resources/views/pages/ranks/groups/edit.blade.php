@use('Nova\Ranks\Models\RankItem')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                @can('viewAny', $group::class)
                    <x-button :href="route('admin.ranks.groups.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form :action="route('admin.ranks.groups.update', $group)" method="PUT">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <flux:input label="Name" name="name" :value="old('name', $group->name)"></flux:input>

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
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Ranks assigned to this group"></x-panel.header>

                    <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                        @forelse ($group->ranks as $rank)
                            <x-spacing size="row" class="group flex items-center justify-between">
                                <div class="flex items-center gap-x-3">
                                    <div class="flex items-center gap-x-3">
                                        <x-status :status="$rank->status"></x-status>
                                        <x-rank :rank="$rank"></x-rank>
                                    </div>
                                    <div class="truncate font-medium text-gray-950 dark:text-white">
                                        {{ $rank->name?->name }}
                                    </div>
                                </div>

                                @can('update', $rank)
                                    <x-button
                                        :href="route('admin.ranks.items.edit', $rank)"
                                        class="group-hover:visible sm:invisible"
                                        text
                                    >
                                        <x-icon name="edit" size="md"></x-icon>
                                    </x-button>
                                @endcan
                            </x-spacing>
                        @empty
                            <x-empty-state.small
                                icon="rank"
                                title="No ranks found for this rank group"
                                :link="route('admin.ranks.items.create')"
                                :link-access="gate()->allows('create', RankItem::class)"
                                label="Add a rank item &rarr;"
                            ></x-empty-state.small>
                        @endforelse
                    </x-panel>
                </x-panel>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('admin.ranks.groups.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
