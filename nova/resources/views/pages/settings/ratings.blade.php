@extends($meta->template)

@section('content')
    <x-page-header title="Content Ratings Settings" x-data="{}">
        <x-slot name="controls">
            <x-button type="button" color="white" size="sm" @click="$dispatch('toggle-spotlight')">
                @icon('search', 'h-5 w-5')
                <span class="ml-2">Find a setting</span>
            </x-button>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('settings.update')" method="PUT" id="ratings">
            <x-form.section title="Global Content Ratings" message="Nova provides for two options to track posting activity: by entire posts or by word counts. You can specify whether a specific post type is included in the posting activity from each post type's settings.">
                <x-input.group label="Language" class="w-full md:w-72">
                    <x-rating :value="2" />
                </x-input.group>

                <x-input.group label="Sex" class="w-full md:w-72">
                    <x-rating :value="1" />
                </x-input.group>

                <x-input.group label="Violence" class="w-full md:w-72">
                    <x-rating :value="3" />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Content Warnings" message="You can choose to warn readers about potentially offensive content in a story post if that post meets certain thresholds with any one of the content categories.">
                <x-input.group label="Language" class="w-full md:w-72">
                    <x-input.select>
                        <option value="">Do not warn</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Sex" class="w-full md:w-72">
                    <x-input.select>
                        <option value="">Do not warn</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </x-input.select>
                </x-input.group>

                <x-input.group label="Violence" help="You have chosen to warn readers about this content, but your threshold is set below the global rating for this category. This means that readers will have to manually agree before being allowed to read every story post unless an author specifically sets the rating lower for their post.">
                    <x-input.select class="w-full md:w-72">
                        <option value="">Do not warn</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </x-input.select>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" form="ratings" color="blue">Update</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection