@use('Nova\Foundation\Enums\BasicStatus')
@use('Nova\Ranks\Models\RankItem')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', $name::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.ranks.names.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.ranks.names.update', $name)" method="PUT">
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-input label="Name" name="name" :value="old('name', $name->name)" />

                    <x-switch
                        label="Active"
                        name="status"
                        :checked="old('status', $name->status === BasicStatus::Active)"
                        align="left"
                    />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset>
                <x-panel variant="well">
                    <x-panel.header title="Ranks assigned this name"></x-panel.header>

                    <x-panel>
                        <x-spacing.group divided>
                            @forelse ($name->ranks as $rank)
                                <x-panel.group.row>
                                    <div class="flex items-center gap-3">
                                        <x-rank :$rank />

                                        <div class="flex flex-col gap-0.5">
                                            <x-heading>
                                                {{ $rank->name?->name }}
                                            </x-heading>
                                            <x-badge :color="$rank->status->getColor()">
                                                {{ $rank->status->getLabel() }}
                                            </x-badge>
                                        </div>
                                    </div>

                                    @can('update', $rank)
                                        <x-button
                                            :href="route('admin.ranks.items.edit', $rank)"
                                            variant="subtle"
                                            inset="right top bottom"
                                            square
                                        >
                                            <x-icon :name="Tabler::Pencil" size="sm" />
                                        </x-button>
                                    @endcan
                                </x-panel.group.row>
                            @empty
                                <x-empty>
                                    <x-illustration :name="Illustration::MilitaryRank" />
                                    <x-empty.heading>No ranks found for this rank name</x-empty.heading>

                                    @can('create', RankItem::class)
                                        <x-button :href="route('admin.ranks.items.create')" variant="ghost">
                                            Add a rank item
                                            <span aria-hidden="true">→</span>
                                        </x-button>
                                    @endcan
                                </x-empty>
                            @endforelse
                        </x-spacing.group>
                    </x-panel>
                </x-panel>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.ranks.names.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
