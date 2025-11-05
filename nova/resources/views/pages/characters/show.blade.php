@use('Nova\Departments\Models\Position')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading :heading="$character->display_name">
            <x-slot name="actions">
                <x-button :href="route('admin.characters.index')" variant="ghost">
                    <span aria-hidden="true">←</span>
                    Back
                </x-button>

                @can('update', $character)
                    <x-button :href="route('admin.characters.edit', $character)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm" />
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-heading>

        <div class="space-y-12" x-data="tabsList('info')">
            @if (filled($form->published_fields))
                <x-tab.group>
                    <x-slot name="tabs">
                        <x-tab name="info">
                            <x-icon :name="Tabler::InfoCircle" size="sm" />
                            Basic info
                        </x-tab>
                        <x-tab name="bio">
                            <x-icon :name="Tabler::UserCircle" size="sm" />
                            Bio
                        </x-tab>
                    </x-slot>

                    <x-tab.panel name="info" class="space-y-12">
                        <x-fieldset>
                            <x-fieldset.group constrained>
                                <div>
                                    <x-avatar :src="$character->avatar_url" size="xl"></x-avatar>
                                </div>

                                <div>
                                    <x-rank :rank="$character->rank"></x-rank>
                                </div>
                            </x-fieldset.group>
                        </x-fieldset>

                        <x-panel variant="well">
                            <x-panel.header title="Assigned positions"></x-panel.header>

                            <x-panel>
                                <x-spacing.group divided>
                                    @forelse ($character->positions as $position)
                                        <x-panel.group.row>
                                            <x-heading>{{ $position->name }}</x-heading>
                                        </x-panel.group.row>
                                    @empty
                                        <x-empty>
                                            <x-illustration :name="Illustration::HandpickResume" />
                                            <x-empty.heading>No position(s) assigned</x-empty.heading>
                                        </x-empty>
                                    @endforelse
                                </x-spacing.group>
                            </x-panel>
                        </x-panel>

                        <x-panel variant="well">
                            <x-panel.header title="Assigned users"></x-panel.header>

                            <x-panel>
                                <x-spacing.group divided>
                                    <x-spacing size="md" class="grid lg:grid-cols-2">
                                        <x-panel.stat
                                            label="Active users"
                                            :value="$character->active_users_count"
                                        ></x-panel.stat>
                                        <x-panel.stat
                                            label="Primary users"
                                            :value="$character->primary_users_count"
                                        ></x-panel.stat>
                                    </x-spacing>

                                    <x-spacing size="md" class="grid gap-4 lg:grid-cols-2">
                                        @forelse ($character->users as $user)
                                            <x-avatar.user :$user status>
                                                <x-slot name="subtitle">
                                                    @if ($user->pivot->primary)
                                                        <x-badge color="primary">Primary</x-badge>
                                                    @endif
                                                </x-slot>
                                            </x-avatar.user>
                                        @empty
                                            <div class="lg:col-span-2">
                                                <x-empty>
                                                    <x-illustration :name="Illustration::Users" />
                                                    <x-empty.heading>No user(s) assigned</x-empty.heading>
                                                    <x-empty.text>
                                                        There aren’t any users assigned to this character.
                                                    </x-empty.text>

                                                    @can('viewAny', Position::class)
                                                        <x-button
                                                            :href="route('admin.positions.index')"
                                                            variant="ghost"
                                                        >
                                                            Assign users
                                                            <span aria-hidden="true">→</span>
                                                        </x-button>
                                                    @endcan
                                                </x-empty>
                                            </div>
                                        @endforelse
                                    </x-spacing>
                                </x-spacing.group>
                            </x-panel>
                        </x-panel>
                    </x-tab.panel>

                    <x-tab.panel name="bio" class="prose dark:prose-invert w-full max-w-md">
                        <livewire:dynamic-form
                            :form="$form"
                            :submission="$character->characterFormSubmission"
                            :owner="$character"
                            :admin="true"
                            :static="true"
                        />
                    </x-tab.panel>
                </x-tab.group>
            @endif
        </div>
    </x-spacing>
</x-admin-layout>
