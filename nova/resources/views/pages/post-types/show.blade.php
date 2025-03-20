@use('Nova\Stories\Enums\PostTypeField')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="actions">
                @can('viewAny', $postType::class)
                    <x-button :href="route('admin.post-types.index')" plain>&larr; Back</x-button>
                @endcan

                @can('update', $postType)
                    <x-button :href="route('admin.post-types.edit', $postType)" color="primary">
                        <x-icon name="edit" size="sm"></x-icon>
                        Edit
                    </x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <div class="space-y-12">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Name">
                        <x-text>{{ $postType->name }}</x-text>
                    </x-fieldset.field>

                    @if (filled($postType->description))
                        <x-fieldset.field label="Description">
                            <x-text>{{ $postType->description }}</x-text>
                        </x-fieldset.field>
                    @endif

                    <x-fieldset.field label="Visibility">
                        <div data-slot="text">
                            <x-badge>
                                {{ $postType->visibility->getLabel() }}
                            </x-badge>
                        </div>
                    </x-fieldset.field>

                    <x-fieldset.field label="Status">
                        <div data-slot="text">
                            <x-badge :color="$postType->status->getColor()">
                                {{ $postType->status->getLabel() }}
                            </x-badge>
                        </div>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-panel variant="well">
                <x-panel.header title="Details"></x-panel.header>

                <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                    @if (filled($postType->description))
                        <x-spacing size="md">
                            <x-text size="lg">{{ $postType->description }}</x-text>
                        </x-spacing>
                    @endif

                    <x-spacing height="md">
                        <div class="grid grid-cols-1 lg:grid-cols-3">
                            <x-panel.stat
                                label="Total published posts"
                                :value="$postType->published_posts_count"
                            ></x-panel.stat>
                            <x-panel.stat label="Icon">
                                @if (filled($postType->icon))
                                    <x-icon :name="$postType->icon" size="h-11 w-11 md:h-10 md:w-10"></x-icon>
                                @else
                                    &mdash;
                                @endif
                            </x-panel.stat>
                            <x-panel.stat label="Accent color">
                                <span style="color: {{ $postType->color }}">{{ $postType->color }}</span>
                            </x-panel.stat>
                        </div>
                    </x-spacing>
                </x-panel>
            </x-panel>

            <x-panel variant="well">
                <x-panel.header title="Fields"></x-panel.header>

                <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                    @foreach (PostTypeField::cases() as $field)
                        @if ($postType->fields->{$field->value}->enabled)
                            <x-spacing size="row" class="flex items-center gap-x-3 font-medium">
                                <div class="flex items-center">
                                    <div class="h-2 w-2 rounded-full bg-success-500"></div>
                                </div>

                                <span>{{ $field->getLabel() }} field</span>

                                @if ($postType->fields->{$field->value}->required)
                                    <x-badge>Required</x-badge>
                                @endif
                            </x-spacing>
                        @endif
                    @endforeach
                </x-panel>
            </x-panel>

            <x-panel variant="well">
                <x-panel.header title="Options"></x-panel.header>

                <x-panel class="divide-y divide-gray-950/5 dark:divide-white/5">
                    @if ($postType->options->notifiesUsers)
                        <x-spacing size="row" class="flex items-center gap-3 font-medium">
                            <x-icon name="notification" size="md"></x-icon>
                            <span>Sends notifications when published</span>
                        </x-spacing>
                    @else
                        <x-spacing size="row" class="flex items-center gap-3 font-medium">
                            <x-icon name="notification-off" size="md"></x-icon>
                            <span>Does not send notifications when published</span>
                        </x-spacing>
                    @endif

                    @if ($postType->options->includedInPostTracking)
                        <x-spacing size="row" class="flex items-center gap-3 font-medium">
                            <x-icon name="chart" size="md"></x-icon>
                            <span>Included in activity tracking stats</span>
                        </x-spacing>
                    @endif

                    @if ($postType->options->allowsMultipleAuthors)
                        <x-spacing size="row" class="flex items-center gap-3 font-medium">
                            <x-icon name="users" size="md"></x-icon>
                            <span>Allows multiple authors</span>
                        </x-spacing>
                    @endif

                    @if ($postType->options->allowsCharacterAuthors)
                        <x-spacing size="row" class="flex items-center gap-3 font-medium">
                            <x-icon name="characters" size="md"></x-icon>
                            <span>Allows characters as authors</span>
                        </x-spacing>
                    @endif

                    @if ($postType->options->allowsUserAuthors)
                        <x-spacing size="row" class="flex items-center gap-3 font-medium">
                            <x-icon name="user" size="md"></x-icon>
                            <span>Allows users as authors</span>
                        </x-spacing>
                    @endif

                    @if ($postType->options->showContentInTimelineView)
                        <x-spacing size="row" class="flex items-center gap-3 font-medium">
                            <x-icon name="timeline" size="md"></x-icon>
                            <span>Show content in timeline view</span>
                        </x-spacing>
                    @endif

                    @if ($postType->role)
                        <x-spacing size="row" class="flex items-center gap-3 font-medium">
                            <x-icon name="shield" size="md"></x-icon>
                            <span>Requires {{ $postType->role->display_name }} role</span>
                        </x-spacing>
                    @endif

                    <x-spacing size="row" class="flex items-center gap-3 font-medium">
                        @if ($postType->options->editTimeframe->value === 'never')
                            <x-icon name="edit-off" size="md"></x-icon>
                            <span>{{ $postType->options->editTimeframe->getLabel() }}</span>
                        @else
                            <x-icon name="edit" size="md"></x-icon>
                            <span>
                                Can be edited for {{ $postType->options->editTimeframe->getLabel() }} after publishing
                            </span>
                        @endif
                    </x-spacing>
                </x-panel>
            </x-panel>
        </div>
    </x-spacing>
</x-admin-layout>
