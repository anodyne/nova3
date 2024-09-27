@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header :$meta>
            <x-slot name="actions">
                <x-button :href="route('admin.characters.index')" plain>&larr; Back</x-button>

                @can('update', $character)
                    <x-button :href="route('admin.characters.edit', $character)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <div class="space-y-12" x-data="tabsList('info')">
            @if (filled($form->published_fields))
                <x-tab.group name="character">
                    <x-tab.heading name="info">
                        <x-icon name="info" size="sm"></x-icon>
                        Basic info
                    </x-tab.heading>
                    <x-tab.heading name="bio">
                        <x-icon name="user-profile" size="sm"></x-icon>
                        Bio
                    </x-tab.heading>
                </x-tab.group>
            @endif

            <div class="space-y-12" x-show="isTab('info')">
                <x-fieldset>
                    <x-fieldset.field-group constrained>
                        <div>
                            <x-avatar :src="$character->avatar_url" size="xl"></x-avatar>
                        </div>

                        <x-fieldset.field label="Name">
                            <x-text>{{ $character->display_name }}</x-text>
                        </x-fieldset.field>

                        <div>
                            <x-rank :rank="$character->rank"></x-rank>
                        </div>
                    </x-fieldset.field-group>
                </x-fieldset>

                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Assigned positions</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                            @forelse ($character->positions as $position)
                                <x-spacing size="sm">
                                    <div class="truncate font-medium text-gray-900 dark:text-white">
                                        {{ $position->name }}
                                    </div>
                                </x-spacing>
                            @empty
                                <x-empty-state.small icon="list" title="No position(s) assigned"></x-empty-state.small>
                            @endforelse
                        </x-panel>
                    </x-spacing>
                </x-panel>

                <x-panel well>
                    <x-spacing size="sm">
                        <x-fieldset.legend>Assigned users</x-fieldset.legend>
                    </x-spacing>

                    <x-spacing size="2xs">
                        <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                            <x-spacing size="sm" class="grid lg:grid-cols-2">
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
                                    <x-avatar.user :user="$user">
                                        <x-slot name="secondary">
                                            <div class="flex items-center gap-x-2">
                                                <x-badge :color="$user->status->color()">
                                                    {{ $user->status->getLabel() }}
                                                </x-badge>

                                                @if ($user->pivot->primary)
                                                    <x-badge color="primary">Primary</x-badge>
                                                @endif
                                            </div>
                                        </x-slot>
                                    </x-avatar.user>
                                @empty
                                    <div class="lg:col-span-2">
                                        <x-empty-state.small
                                            icon="users"
                                            title="No users assigned"
                                            message="There aren’t any positions assigned to this department. Assign some positions to this department to populate this list."
                                            :link-access="gate()->allows('viewAny', Nova\Departments\Models\Position::class)"
                                            :link="route('admin.positions.index')"
                                            label="Assign positions"
                                        ></x-empty-state.small>
                                    </div>
                                @endforelse
                            </x-spacing>
                        </x-panel>
                    </x-spacing>
                </x-panel>
            </div>

            <div class="w-full max-w-md" x-show="isTab('bio')">
                <livewire:dynamic-form
                    :form="$form"
                    :submission="$character->characterFormSubmission"
                    :owner="$character"
                    :admin="true"
                    :static="true"
                />
            </div>
        </div>
    </x-spacing>
@endsection
