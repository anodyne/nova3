@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$postType->name">
        <x-slot name="pretitle">
            <a href="{{ route('post-types.index') }}">Post Types</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $postType)
                <x-button-link :href="route('post-types.edit', $postType)" color="blue">Edit Post Type</x-button-link>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form action="">
            <x-form.section title="Post Type Info" message="A post type defines how different types of story entries are displayed and used. Using post types, you can setup your writing features exactly how you want them for your game.">
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
                    <div class="flex items-center space-x-4">
                        <div class="h-8 w-8 rounded-md" style="background-color:{{ $postType->color }}"></div>
                        <span class="text-gray-600">{{ $postType->color }}</span>
                    </div>
                </x-input.group>

                <x-input.group label="Icon">
                    @icon($postType->icon, 'h-8 w-8 text-gray-500')
                </x-input.group>

                <x-input.group label="Visibility">
                    <p class="font-semibold">{{ $postType->visibility }}</p>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Fields" message="Post types control which fields are available when creating a post of that type. You can turn any of these fields on/off to suit your game's needs.">
                <div class="font-medium space-y-6">
                    @if ($postType->fields->title)
                        <div class="flex items-center space-x-2 text-green-11">
                            @icon('check-alt', 'h-6 w-6 flex-shrink-0 text-green-9')
                            <span>Title field</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-11">
                            @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-9')
                            <span>Title field</span>
                        </div>
                    @endif

                    @if ($postType->fields->day)
                        <div class="flex items-center space-x-2 text-green-11">
                            @icon('check-alt', 'h-6 w-6 flex-shrink-0 text-green-9')
                            <span>Day field</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-11">
                            @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-9')
                            <span>Day field</span>
                        </div>
                    @endif

                    @if ($postType->fields->time)
                        <div class="flex items-center space-x-2 text-green-11">
                            @icon('check-alt', 'h-6 w-6 flex-shrink-0 text-green-9')
                            <span>Time field</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-11">
                            @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-9')
                            <span>Time field</span>
                        </div>
                    @endif

                    @if ($postType->fields->location)
                        <div class="flex items-center space-x-2 text-green-11">
                            @icon('check-alt', 'h-6 w-6 flex-shrink-0 text-green-9')
                            <span>Location field</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-11">
                            @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-9')
                            <span>Location field</span>
                        </div>
                    @endif

                    @if ($postType->fields->content)
                        <div class="flex items-center space-x-2 text-green-11">
                            @icon('check-alt', 'h-6 w-6 flex-shrink-0 text-green-9')
                            <span>Content field</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-11">
                            @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-9')
                            <span>Content field</span>
                        </div>
                    @endif

                    @if ($postType->fields->rating)
                        <div class="flex items-center space-x-2 text-green-11">
                            @icon('check-alt', 'h-6 w-6 flex-shrink-0 text-green-9')
                            <span>Rating field</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-11">
                            @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-9')
                            <span>Rating field</span>
                        </div>
                    @endif
                </div>
            </x-form.section>

            <x-form.section title="Options" message="Post types control the behavior of a post of that type with a wide range of options. You can turn any of these fields on/off to suit your game's needs.">
                <div class="font-medium space-y-6">
                    @if ($postType->options->notifyUsers)
                        <div class="flex items-center space-x-2 text-green-11">
                            @icon('check-alt', 'h-6 w-6 flex-shrink-0 text-green-9')
                            <span>Sends notifications to users when published</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-11">
                            @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-9')
                            <span>Does not send notifications to users when published</span>
                        </div>
                    @endif

                    @if ($postType->options->notifyDiscord)
                        <div class="flex items-center space-x-2 text-green-11">
                            @icon('check-alt', 'h-6 w-6 flex-shrink-0 text-green-9')
                            <span>Sends notifications to Discord when published</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-11">
                            @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-9')
                            <span>Does not send notifications to Discord when published</span>
                        </div>
                    @endif

                    @if ($postType->options->includeInPostCounts)
                        <div class="flex items-center space-x-2 text-green-11">
                            @icon('check-alt', 'h-6 w-6 flex-shrink-0 text-green-9')
                            <span>Is included in post counts</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-11">
                            @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-9')
                            <span>Is not included in post counts</span>
                        </div>
                    @endif

                    @if ($postType->options->multipleAuthors)
                        <div class="flex items-center space-x-2 text-green-11">
                            @icon('check-alt', 'h-6 w-6 flex-shrink-0 text-green-9')
                            <span>Allows multiple authors</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-11">
                            @icon('close-alt', 'h-6 w-6 flex-shrink-0 text-red-9')
                            <span>Does not allow multiple authors</span>
                        </div>
                    @endif
                </div>
            </x-form.section>

            <x-form.footer>
                <x-button-link :href="route('post-types.index')" color="white">Back</x-button-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
