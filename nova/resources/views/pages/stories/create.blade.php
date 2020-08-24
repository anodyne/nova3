@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Story">
        <x-slot name="pretitle">
            <a href="{{ route('stories.index') }}">Stories</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('stories.store')">
            <x-form.section title="Story Info">
                <x-input.group label="Title" for="title" :error="$errors->first('title')">
                    <x-input.text id="title" name="title" data-cy="title" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="10">{{ old('description') }}</x-input.textarea>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Story Status & Dates" message="Setting the status of a story lets you control the stories that players are able to write within. You can have as many currently running stories as you want. If you have more than 1 current story, players will be given the option to choose which story they want to write their post within.">
                <x-input.group label="Status">
                    <x-input.select name="status" id="status">
                        <option value="upcoming">Upcoming</option>
                        <option value="current">Current</option>
                        <option value="completed">Completed</option>
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Start Date" for="start_date">
                    <x-input.field>
                        <x-slot name="leadingAddOn">@icon('calendar')</x-slot>

                        <x-ui-pikaday name="start_date" id="start_date" format="YYYY-MM-DD" :value="old('start_date', '')" class="form-field w-full | md:w-1/2" />
                    </x-input.field>
                </x-input.group>

                <x-input.group label="End Date" for="end_date">
                    <x-input.field>
                        <x-slot name="leadingAddOn">@icon('calendar')</x-slot>

                        <x-ui-pikaday name="end_date" id="end_date" format="YYYY-MM-DD" :value="old('end_date', '')" class="form-field" />
                    </x-input.field>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Story Hierarchy" message="Stories can be organized inside any story on the timeline and then ordered within the parent story in whatever order you'd like.">
                @livewire('stories:hierarchy', [
                    'parentId' => old('parent_id', 1),
                    'direction' => old('direction', request()->direction ?? 'after'),
                    'neighbor' => old('neighbor', request()->neighbor)
                ])
            </x-form.section>

            <x-form.section title="Images" message="Story images should be 4 times larger than the size you want to display it at (for high resolution displays), but not more than 5MB in size.">
                <div class="max-w-lg flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="text-center">
                        @icon('image-add', 'mx-auto h-12 w-12 text-gray-400')
                        <p x-data="{ focused: false }" class="mt-1 text-sm text-gray-600">
                            <input
                                x-on:focus="focused = true"
                                x-on:blur="focused = false"
                                type="file"
                                id="upload-images"
                                wire:model="image"
                                class="sr-only"
                                multiple
                            >
                            <label
                                for="upload-image"
                                class="cursor-pointer font-medium text-blue-600 hover:text-blue-500 transition duration-150 ease-in-out"
                                x-bind:class="{ 'outline-none underline': focused }"
                            >
                                Upload files
                            </label>
                        </p>
                        <p class="mt-1 text-xs text-gray-500">
                            PNG, JPG, GIF up to 5MB
                        </p>
                    </div>
                </div>
            </x-form.section>

            <x-form.section>
                <x-input.group label="Story Summary">
                    <x-input.rich-text name="summary" :initial-value="old('summary')" />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Add Story</button>

                <a href="{{ route('stories.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
