@extends($meta->template)

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">
                <div class="flex items-center gap-x-4">
                    <x-avatar :src="$character->avatar_url" size="xl"></x-avatar>
                    <div class="flex flex-col gap-y-1">
                        {{ $character->display_name }}
                        <x-rank :rank="$character->rank"></x-rank>
                    </div>
                </div>
            </x-slot>

            <x-slot name="actions">
                <x-button :href="route('characters.index')" plain>&larr; Back</x-button>

                @can('update', $character)
                    <x-button :href="route('characters.edit', $character)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <div class="space-y-12">
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
                            <x-panel.stat label="Active users" :value="$character->active_users_count"></x-panel.stat>
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
                                        :link="route('positions.index')"
                                        label="Assign positions"
                                    ></x-empty-state.small>
                                </div>
                            @endforelse
                        </x-spacing>
                    </x-panel>
                </x-spacing>
            </x-panel>
        </div>
    </x-spacing>
@endsection
