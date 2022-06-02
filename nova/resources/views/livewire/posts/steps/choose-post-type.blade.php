<x-write-post-wizard-layout :steps="$steps">
    <x-content-box>
        <fieldset>
            <legend class="text-base font-medium text-gray-900 dark:text-gray-100 sr-only">Choose a post type</legend>

            <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                @foreach ($postTypes as $type)
                    <label class="relative bg-white dark:bg-gray-700 border border-gray-200 dark:border-none rounded-lg shadow-sm dark:shadow-none dark:highlight-white/5 p-4 flex cursor-pointer focus:outline-none hover:border-gray-300 dark:hover:bg-gray-600/70 transition" wire:click="setPostType({{ $type }})">
                        <input type="radio" name="post-type" value="{{ $type->id }}" class="sr-only" aria-labelledby="post-type-{{ $type->id }}-label" aria-describedby="post-type-{{ $type->id }}-description-0 post-type-{{ $type->id }}-description-1">
                        <span class="flex-1 flex">
                            <span class="flex flex-col">
                                @isset($type->icon)
                                    <span style="color:{{ $type->color }}">
                                        @icon($type->icon, 'h-12 w-12')
                                    </span>
                                @else
                                    <div class="h-12 w-12"></div>
                                @endif

                                <h3 class="inline-flex items-center text-lg font-semibold text-gray-900 dark:text-gray-100 mt-2" id="project-type-{{ $type->id }}-label">
                                    {{ $type->name }}
                                </h3>

                                @if ($type->role)
                                    <div class="mt-6">
                                        <x-badge size="xs" color="gray" class="mt-1">{{ $type->role->display_name }}</x-badge>
                                    </div>
                                @endif
                            </span>
                        </span>

                        @if ($postType?->id === $type->id)
                            @icon('check', 'h-6 w-6 text-blue-500')
                        @endif

                        <span
                            @class([
                                'absolute -inset-px rounded-lg pointer-events-none',
                                'border border-transparent' => $postType?->id !== $type->id,
                                'border-2 border-blue-500' => $postType?->id === $type->id,
                            ])
                            aria-hidden="true"
                        ></span>
                    </label>
                @endforeach
            </div>
        </fieldset>
    </x-content-box>

    @isset ($postType)
        <x-content-box height="sm" class="flex flex-col space-y-4 rounded-b-lg border-t border-gray-200 dark:border-gray-200/10 md:flex-row-reverse md:items-center md:space-y-0 md:space-x-6 md:space-x-reverse justify-between">
            <div class="flex flex-col md:flex-row-reverse md:items-center md:space-x-reverse space-y-4 md:space-y-0 md:space-x-6">
                <x-button wire:click="nextStep" color="blue">Next: Write Post</x-button>
            </div>
        </x-content-box>
    @endisset
</x-write-post-wizard-layout>