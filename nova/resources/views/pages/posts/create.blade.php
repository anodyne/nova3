@extends($__novaTemplate)

@section('writing.leading')
{{-- <a href="{{ route('posts.create') }}" class="flex items-center text-gray-500 text-xs tracking-wide font-semibold mb-1">
    @icon('chevron-left', 'h-4 w-4 text-gray-400')
    <span class="ml-1">Choose a different post type</span>
</a>

@if ($stories->count() === 0)
<div class="font-bold text-lg">No current story</div>
@endif

@if ($stories->count() === 1)
<div class="font-bold text-lg">{{ $stories->first()->title }}</div>
@endif

@if ($stories->count() > 1)
<div>
    <!--
        Custom select controls like this require a considerable amount of JS to implement from scratch. We're planning
        to build some low-level libraries to make this easier with popular frameworks like React, Vue, and even Alpine.js
        in the near future, but in the mean time we recommend these reference guides when building your implementation:

        https://www.w3.org/TR/wai-aria-practices/#Listbox
        https://www.w3.org/TR/wai-aria-practices/examples/listbox/listbox-collapsible.html
    -->
    <div class="space-y-1">
        <div class="relative">
            <span class="inline-block w-full rounded-md shadow-sm">
                <button type="button" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label" class="cursor-default relative w-full rounded-md border border-gray-300 bg-white pl-3 pr-10 py-2 text-left focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    <span class="block truncate">
                        {{ $stories->first()->title }}
                    </span>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                            <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                </button>
            </span>

            <!-- Select popover, show/hide based on select state. -->
            <div class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-10">
                <ul tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-item-3" class="max-h-60 rounded-md py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5">
                    <!--
                        Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                        Highlighted: "text-white bg-indigo-600", Not Highlighted: "text-gray-900"
                    -->
                    @foreach ($stories as $story)
                        <li id="listbox-option-0" role="option" class="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9">
                            <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                            <span class="font-normal block truncate">
                                {{ $story->title }}
                            </span>

                            <!--
                                Checkmark, only display for selected option.

                                Highlighted: "text-white", Not Highlighted: "text-indigo-600"
                            -->
                            <span class="text-indigo-600 absolute inset-y-0 right-0 flex items-center pr-4">
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </li>
                    @endforeach

                    <!-- More options... -->
                </ul>
            </div>
        </div>
    </div>

    <x-dropdown>
        <div class="flex items-center space-x-3">
            <div class="font-bold text-lg">{{ $stories->first()->title }}</div>
            <span>
                @icon('chevron-down', 'h-4 w-4 text-gray-400')
            </span>
        </div>

        <x-slot name="dropdown">
            @foreach ($stories as $story)
            <a role="button" class="{{ $component->link() }}">{{ $story->title }}</a>
            @endforeach
        </x-slot>
    </x-dropdown>
</div>
@endif --}}
@endsection

@section('writing.trailing')
<button class="button">Save</button>
<button class="button button-primary">Publish</button>
@endsection

@section('content')
<div class="grid gap-8 | lg:grid-cols-4">
    <div class="lg:col-span-3">
        <div class="w-full mb-8">
            @if ($stories->count() === 1)
                <p class="text-base leading-6 font-medium text-gray-500 mb-2">{{ $stories->first()->title }}</p>
            @endif

            @if ($stories->count() > 1)
                <p class="text-base leading-6 font-medium text-gray-500 mb-2">{{ $stories->first()->title }}</p>
            @endif

            @if ($postType->fields->title)
                <x-input.group>
                    <input type="text" class="w-full bg-transparent appearance-none focus:outline-none text-3xl leading-9 font-extrabold text-gray-900 tracking-tight placeholder-gray-400 | sm:text-4xl sm:leading-10 md:text-5xl md:leading-14" placeholder="Title here">
                </x-input.group>
            @endif

            @if ($postType->fields->time || $postType->fields->day || $postType->fields->location)
                <div class="flex flex-col space-y-8 text-gray-600 text-lg font-medium mt-8 | md:mt-4 md:flex-row md:items-center md:space-x-8 md:space-y-0">
                    @if ($postType->fields->day)
                        <div class="group flex items-center w-full space-x-2">
                            @icon('calendar', 'h-5 w-5 text-gray-400 group-focus:text-gray-700')
                            <input type="text" class="w-full bg-transparent appearance-none focus:outline-none text-base font-medium leading-6 text-gray-700 placeholder-gray-400" placeholder="Add day">
                        </div>
                    @endif

                    @if ($postType->fields->time)
                        <div class="group flex items-center w-full space-x-2">
                            @icon('clock', 'h-5 w-5 text-gray-400 group-focus:text-gray-700')
                            <input type="text" class="w-full bg-transparent appearance-none focus:outline-none text-base font-medium leading-6 text-gray-700 placeholder-gray-400" placeholder="Add time">
                        </div>
                    @endif

                    @if ($postType->fields->location)
                    <div class="group flex items-center w-full space-x-2">
                            @icon('location', 'h-5 w-5 text-gray-400 group-focus:text-gray-700')
                            <input type="text" class="w-full bg-transparent appearance-none focus:outline-none text-base font-medium leading-6 text-gray-700 placeholder-gray-400" placeholder="Add location">
                        </div>
                    @endif
                </div>
            @endif
        </div>

        @if ($postType->fields->content)
        <x-input.group>
            <x-input.rich-text name="content" :initial-value="old('content')" />
        </x-input.group>
        @endif
    </div>

    <div class="space-y-8">
        <div class="flex flex-col">
            <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Your characters</span>
            Select your characters
        </div>

        @if ($postType->options->multipleAuthors)
        <div class="flex flex-col">
            <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Other characters</span>
            Add more characters
        </div>

        <div class="flex flex-col">
            <span class="text-xs uppercase tracking-wide font-semibold text-gray-500">Other contributors</span>
            Add other contributors
        </div>
        @endif
    </div>
</div>
@endsection
