@use('Nova\Stories\Enums\PostTypeField')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    @if (filled($postType->icon))
                        <x-icon :name="$postType->icon" size="xl" />
                    @endif

                    {{ $postType->name }}
                </div>
            </x-slot>

            <x-slot name="description">
                <x-metadata.group size="md" gap="lg">
                    <x-metadata label="Visibility">
                        {{ $postType->visibility->getLabel() }}
                    </x-metadata>

                    <x-metadata label="Status">
                        <x-badge :color="$postType->status->getColor()" size="md">
                            {{ $postType->status->getLabel() }}
                        </x-badge>
                    </x-metadata>
                </x-metadata.group>
            </x-slot>

            <x-slot name="actions">
                @can('viewAny', $postType::class)
                    <x-button :href="route('admin.post-types.index')" variant="ghost">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                @endcan

                @can('update', $postType)
                    <x-button :href="route('admin.post-types.edit', $postType)" variant="primary">
                        <x-icon :name="Tabler::Pencil" size="sm" />
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-heading>

        <div class="space-y-12">
            <x-panel variant="well">
                <x-panel.header title="Details"></x-panel.header>

                <x-panel>
                    <x-spacing.group divided>
                        @if (filled($postType->description))
                            <x-panel.group.row>
                                <x-text size="lg">{{ $postType->description }}</x-text>
                            </x-panel.group.row>
                        @endif

                        <x-spacing size="md">
                            <div class="grid grid-cols-1 lg:grid-cols-2">
                                <x-panel.stat
                                    label="Total published posts"
                                    :value="$postType->published_posts_count"
                                ></x-panel.stat>

                                <x-panel.stat label="Accent color">
                                    <span style="color: {{ $postType->color }}">{{ $postType->color }}</span>
                                </x-panel.stat>
                            </div>
                        </x-spacing>
                    </x-spacing.group>
                </x-panel>
            </x-panel>

            <x-panel variant="well">
                <x-panel.header title="Fields" :icon="Tabler::Forms"></x-panel.header>

                <x-panel>
                    <x-spacing.group divided>
                        @foreach (PostTypeField::cases() as $field)
                            <x-panel.group.row>
                                <div class="flex items-center gap-3">
                                    @if ($postType->fields->{$field->value}->enabled)
                                        <x-icon :name="Tabler::CircleCheck" size="md" class="text-success-500" />
                                    @else
                                        <x-icon :name="Tabler::CircleX" size="md" class="text-danger-500" />
                                    @endif

                                    <x-heading level="4">{{ $field->getLabel() }} field</x-heading>

                                    @if ($postType->fields->{$field->value}->required)
                                        <x-badge size="md">Required</x-badge>
                                    @endif
                                </div>
                            </x-panel.group.row>
                        @endforeach
                    </x-spacing.group>
                </x-panel>
            </x-panel>

            <x-panel variant="well">
                <x-panel.header title="Options" :icon="Tabler::Adjustments"></x-panel.header>

                <x-panel>
                    <x-spacing.group divided>
                        @if ($postType->options->notifiesUsers)
                            <x-panel.group.row>
                                <div class="flex items-center gap-3 text-sm/6 font-medium">
                                    <x-icon :name="Tabler::Notification" size="md" />
                                    <x-heading level="4">Sends notifications when published</x-heading>
                                </div>
                            </x-panel.group.row>
                        @else
                            <x-panel.group.row>
                                <div class="flex items-center gap-3 text-sm/6 font-medium">
                                    <x-icon :name="Tabler::NotificationOff" size="md" />
                                    <x-heading level="4">Does not send notifications when published</x-heading>
                                </div>
                            </x-panel.group.row>
                        @endif

                        @if ($postType->options->includedInPostTracking)
                            <x-panel.group.row>
                                <div class="flex items-center gap-3 text-sm/6 font-medium">
                                    <x-icon :name="Tabler::ChartBar" size="md" />
                                    <x-heading level="4">Inlcuded in activity tracking stats</x-heading>
                                </div>
                            </x-panel.group.row>
                        @endif

                        @if ($postType->options->allowsMultipleAuthors)
                            <x-panel.group.row>
                                <div class="flex items-center gap-3 text-sm/6 font-medium">
                                    <x-icon :name="Tabler::Users" size="md" />
                                    <x-heading level="4">Allows multiple authors</x-heading>
                                </div>
                            </x-panel.group.row>
                        @endif

                        @if ($postType->options->allowsCharacterAuthors)
                            <x-panel.group.row>
                                <div class="flex items-center gap-3 text-sm/6 font-medium">
                                    <x-icon :name="Tabler::MasksTheater" size="md" />
                                    <x-heading level="4">Allows characters as authors</x-heading>
                                </div>
                            </x-panel.group.row>
                        @endif

                        @if ($postType->options->allowsUserAuthors)
                            <x-panel.group.row>
                                <div class="flex items-center gap-3 text-sm/6 font-medium">
                                    <x-icon :name="Tabler::User" size="md" />
                                    <x-heading level="4">Allows users as authors</x-heading>
                                </div>
                            </x-panel.group.row>
                        @endif

                        @if ($postType->options->showContentInTimelineView)
                            <x-panel.group.row>
                                <div class="flex items-center gap-3 text-sm/6 font-medium">
                                    <x-icon :name="Tabler::TimelineEvent" size="md" />
                                    <x-heading level="4">Shows content in the timeline view</x-heading>
                                </div>
                            </x-panel.group.row>
                        @endif

                        @if ($postType->role)
                            <x-panel.group.row>
                                <div class="flex items-center gap-3 text-sm/6 font-medium">
                                    <x-icon :name="Tabler::ShieldLock" size="md" />
                                    <x-heading level="4">Requires {{ $postType->role->display_name }} role</x-heading>
                                </div>
                            </x-panel.group.row>
                        @endif

                        <x-panel.group.row>
                            @if ($postType->options->editTimeframe->value === 'never')
                                <div class="flex items-center gap-3 text-sm/6 font-medium">
                                    <x-icon :name="Tabler::PencilOff" size="md" />
                                    <x-heading level="4">
                                        {{ $postType->options->editTimeframe->getLabel() }}
                                    </x-heading>
                                </div>
                            @else
                                <div class="flex items-center gap-3 text-sm/6 font-medium">
                                    <x-icon :name="Tabler::Pencil" size="md" />
                                    <x-heading level="4">
                                        Can be edited for {{ $postType->options->editTimeframe->getLabel() }} after
                                        publishing
                                    </x-heading>
                                </div>
                            @endif
                        </x-panel.group.row>
                    </x-spacing.group>
                </x-panel>
            </x-panel>
        </div>
    </x-spacing>
</x-admin-layout>
