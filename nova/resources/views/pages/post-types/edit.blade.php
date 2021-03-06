@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$postType->name">
        <x-slot name="pretitle">
            <a href="{{ route('post-types.index') }}">Post Types</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('post-types.update', $postType)" method="PUT">
            <x-form.section title="Post Type Info" message="A post type defines how different types of story entries are displayed and used. Using post types, you can setup your writing features exactly how you want them for your game.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $postType->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Key" for="key" :error="$errors->first('key')">
                    <x-input.text id="key" name="key" :value="old('key', $postType->key)" data-cy="key" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="3">{{ old('description', $postType->description) }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Accent Color" for="color">
                    <x-buk-color-picker name="color" id="color" :value="old('color', $postType->color)" />
                </x-input.group>

                <x-input.group label="Icon" for="icon">
                    @livewire('icons-select-menu', ['selected' => old('icon', $postType->icon)])
                </x-input.group>

                <x-input.group
                    label="Visibility"
                    for="visibility"
                    help="When displayed on the public site, only in character posts will be visible. Out of character posts will still be visible in the admin panel."
                    :error="$errors->first('visibility')"
                >
                    <x-input.radio
                        label="In character"
                        for="in_character"
                        name="visibility"
                        id="in_character"
                        value="in-character"
                        :checked="old('visibility', $postType->visibility) === 'in-character'"
                        data-cy="visibility"
                    />

                    <span class="ml-6">
                        <x-input.radio
                            label="Out of character"
                            for="out_of_character"
                            name="visibility"
                            id="out_of_character"
                            value="out-of-character"
                            :checked="old('visibility', $postType->visibility) === 'out-of-character'"
                            data-cy="visibility"
                        />
                    </span>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="active" :value="old('active', $postType->active)">
                        Active
                    </x-input.toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Fields" message="Post types control which fields are available when creating a post of that type. You can turn any of these fields on/off to suit your game's needs.">
                <x-input.group>
                    <x-input.toggle
                        field="fields[title]"
                        :value="old('fields[title]', $postType->fields->title)"
                    >
                        Show title field
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="fields[day]"
                        :value="old('fields[day]', $postType->fields->day)"
                    >
                        Show day field
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="fields[time]"
                        :value="old('fields[time]', $postType->fields->time)"
                    >
                        Show time field
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="fields[location]"
                        :value="old('fields[location]', $postType->fields->location)"
                    >
                        Show location field
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="fields[content]"
                        :value="old('fields[content]', $postType->fields->content)"
                    >
                        Show content field
                    </x-input.toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Options" message="Post types control the behavior of a post of that type with a wide range of options. You can turn any of these fields on/off to suit your game's needs.">
                <x-input.group>
                    <x-input.toggle
                        field="options[notifyUsers]"
                        :value="old('options[notifyUsers]', $postType->options->notifyUsers)"
                    >
                        Notify users
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="options[notifyDiscord]"
                        :value="old('options[notifyDiscord]', true)"
                    >
                        Send notification to Discord
                    </x-input.toggle>

                    @if (! app('nova.settings')->discord->storyPostsEnabled)
                        <x-slot name="help">
                            <span class="font-medium">Story post notifications for Discord is currently disabled.</span> You can change this setting, but it will not work until you have enabled sending story post notifications to Discord from the <a class="text-blue-600 hover:text-blue-500 transition ease-in-out duration-150" href="{{ route('settings.index', 'discord') }}">Discord settings</a>.
                        </x-slot>
                    @endif
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="fields[includeInPostCounts]"
                        :value="old('fields[includeInPostCounts]', $postType->options->includeInPostCounts)"
                    >
                        Include in post counts
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="fields[multipleAuthors]"
                        :value="$postType->options->multipleAuthors"
                    >
                        Allow multiple authors
                    </x-input.toggle>
                </x-input.group>

                <x-input.group label="Restrict posting" help="You can set a specific role a user must have in order to use certain post types.">
                    <x-input.select name="role_id" id="role_id" class="w-full | md:w-2/3">
                        <option value="">No role restrictions</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if ($postType->role_id == $role->id) selected @endif>{{ $role->display_name }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Update Post Type</x-button>
                <x-button-link :href="route('post-types.index')" color="white">Cancel</x-button-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
