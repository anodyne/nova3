@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$postType->name">
            <x-slot:actions>
                @can('viewAny', $postType)
                    <x-button.text :href="route('post-types.index')" color="gray" leading="arrow-left">Back</x-button.text>
                @endcan

                @can('update', $postType)
                    <x-button.filled :href="route('post-types.edit', $postType)" color="primary" leading="edit">Edit</x-button.filled>
                @endcan
            </x-slot:actions>
        </x-panel.header>

        <x-form action="">
            <x-form.section title="Post Type Info" message="A post type defines how different types of story entries are displayed and used. Using post types, you can setup your writing features exactly how you want for your game.">
                <x-input.group label="Name">
                    <p class="font-semibold">{{ $postType->name }}</p>
                </x-input.group>

                <x-input.group label="Key">
                    <p class="font-semibold">{{ $postType->key }}</p>
                </x-input.group>

                <x-input.group label="Description">
                    <p class="font-semibold">{{ $postType->description }}</p>
                </x-input.group>

                <x-input.group label="Accent Color">
                    <div class="flex items-center space-x-3">
                        <div class="h-6 w-6 rounded-full" style="background-color:{{ $postType->color }}"></div>
                        <span class="text-gray-500 dark:text-gray-400">{{ $postType->color }}</span>
                    </div>
                </x-input.group>

                <x-input.group label="Icon">
                    <x-icon :name="$postType->icon" size="xl" class="text-gray-500 dark:text-gray-400"></x-icon>
                </x-input.group>

                <x-input.group label="Visibility">
                    <p class="font-semibold">{{ $postType->visibility }}</p>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Fields" message="Post types control which fields are available when creating a post of that type. You can turn any of these fields on/off to suit your game's needs.">
                <div class="font-medium space-y-6">
                    @if ($postType->fields->title->enabled)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Title field</span>

                            @if ($postType->fields->title->required)
                                <span class="text-sm">(required)</span>
                            @endif
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Title field</span>
                        </div>
                    @endif

                    @if ($postType->fields->day->enabled)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Day field</span>

                            @if ($postType->fields->day->required)
                                <span class="text-sm">(required)</span>
                            @endif
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Day field</span>
                        </div>
                    @endif

                    @if ($postType->fields->time->enabled)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Time field</span>

                            @if ($postType->fields->time->required)
                                <span class="text-sm">(required)</span>
                            @endif
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Time field</span>
                        </div>
                    @endif

                    @if ($postType->fields->location->enabled)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Location field</span>

                            @if ($postType->fields->location->required)
                                <span class="text-sm">(required)</span>
                            @endif
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Location field</span>
                        </div>
                    @endif

                    @if ($postType->fields->content->enabled)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Content field</span>

                            @if ($postType->fields->content->required)
                                <span class="text-sm">(required)</span>
                            @endif
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Content field</span>
                        </div>
                    @endif

                    @if ($postType->fields->rating->enabled)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Rating field</span>

                            @if ($postType->fields->rating->required)
                                <span class="text-sm">(required)</span>
                            @endif
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Rating field</span>
                        </div>
                    @endif

                    @if ($postType->fields->summary->enabled)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Summary field</span>

                            @if ($postType->fields->summary->required)
                                <span class="text-sm">(required)</span>
                            @endif
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Summary field</span>
                        </div>
                    @endif
                </div>
            </x-form.section>

            <x-form.section title="Options" message="Post types control the behavior of a post of that type with a wide range of options. You can turn any of these fields on/off to suit your game's needs.">
                <div class="font-medium space-y-6">
                    @if ($postType->options->notifiesUsers)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Sends notifications to users when published</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Does not send notifications to users when published</span>
                        </div>
                    @endif

                    @if ($postType->options->includedInPostTracking)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Is included in post tracking</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Is not included in post counts</span>
                        </div>
                    @endif

                    @if ($postType->options->allowsMultipleAuthors)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Allows multiple authors</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Does not allow multiple authors</span>
                        </div>
                    @endif

                    @if ($postType->options->allowsCharacterAuthors)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Allows characters as authors</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Does not allow characters as authors</span>
                        </div>
                    @endif

                    @if ($postType->options->allowsUserAuthors)
                        <div class="flex items-center space-x-2 text-success-600 dark:text-success-500">
                            <x-icon name="check" size="md" class="shrink-0 text-success-500 dark:text-success-400"></x-icon>
                            <span>Allows users as authors</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-danger-600 dark:text-danger-500">
                            <x-icon name="dismiss" size="md" class="shrink-0 text-danger-500 dark:text-danger-400"></x-icon>
                            <span>Does not allow users as authors</span>
                        </div>
                    @endif
                </div>
            </x-form.section>
        </x-form>
    </x-panel>
@endsection
