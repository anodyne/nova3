@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Post Type">
        <x-slot name="pretitle">
            <a href="{{ route('post-types.index') }}">Post Types</a>
        </x-slot>
    </x-page-header>

    <x-panel
        x-data="{ name: '{{ old('name') }}', key: '{{ old('key') }}', suggestKey: true }"
        x-init="
            $watch('name', value => {
                if (suggestKey) {
                    key = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
                }
            })
        "
    >
        <x-form :action="route('post-types.store')">
            <x-form.section title="Post Type Info" message="A post type defines how different types of story entries are displayed and used. Using post types, you can setup your writing features exactly how you want them for your game.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text x-model="name" id="name" name="name" data-cy="name" />
                </x-input.group>

                <x-input.group label="Key" for="key" :error="$errors->first('key')">
                    <x-input.text x-model="key" x-on:change="suggestKey = false" id="key" name="key" data-cy="key" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="3">{{ old('description') }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Accent Color" for="color">
                    <x-buk-color-picker name="color" id="color" :value="old('color', '#000000')" />
                </x-input.group>

                <x-input.group label="Icon" for="icon">
                    @livewire('icons-select-menu', ['selected' => old('icon')])
                </x-input.group>

                <x-input.group
                    label="Visibility"
                    for="visibility"
                    help="When displayed on the public site, only in character posts will be visible. Out of character posts will still be visible in the admin panel."
                    :error="$errors->first('visibility')"
                >
                    <x-input.radio label="In character" for="in_character" name="visibility" id="in_character" value="in-character" />

                    <span class="ml-6">
                        <x-input.radio label="Out of character" for="out_of_character" name="visibility" id="out_of_character" value="out-of-character" />
                    </span>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="active"
                        :value="old('active', true)"
                        active-text="Active"
                        inactive-text="Inactive"
                    />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Fields" message="Post types control which fields are available when creating a post of that type. You can turn any of these fields on/off to suit your game's needs.">
                <x-input.group>
                    <x-input.toggle
                        field="fields[title]"
                        :value="old('fields[title]', true)"
                        active-text="Show title field"
                        inactive-text="Hide title field"
                    />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="fields[day]"
                        :value="old('fields[day]', true)"
                        active-text="Show day field"
                        inactive-text="Hide day field"
                    />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="fields[time]"
                        :value="old('fields[time]', true)"
                        active-text="Show time field"
                        inactive-text="Hide time field"
                    />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="fields[location]"
                        :value="old('fields[location]', true)"
                        active-text="Show location field"
                        inactive-text="Hide location field"
                    />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="fields[content]"
                        :value="old('fields[content]', true)"
                        active-text="Show content field"
                        inactive-text="Hide content field"
                    />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Options" message="Post types control the behavior of a post of that type with a wide range of options. You can turn any of these fields on/off to suit your game's needs.">
                <x-input.group>
                    <x-input.toggle
                        field="options[notifyUsers]"
                        :value="old('options[notifyUsers]', true)"
                        active-text="Notify users"
                        inactive-text="Do not notify users"
                    />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="options[notifyDiscord]"
                        :value="old('options[notifyDiscord]', app('nova.settings')->discord->storyPostsEnabled)"
                        active-text="Send notification to Discord"
                        inactive-text="Do not send notification to Discord"
                    />

                    @if (! app('nova.settings')->discord->storyPostsEnabled)
                        <x-slot name="help">
                            <span class="font-medium">Story post notifications for Discord is currently disabled.</span> You can change this setting, but it will not work until you have enabled sending story post notifications to Discord from the <a class="text-blue-600 hover:text-blue-500 transition ease-in-out duration-150" href="{{ route('settings.index', 'discord') }}">Discord settings</a>.
                        </x-slot>
                    @endif
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="options[includeInPostCounts]"
                        :value="old('options[includeInPostCounts]', true)"
                        active-text="Include in post counts"
                        inactive-text="Exclude from post counts"
                    />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="options[multipleAuthors]"
                        :value="old('options[multipleAuthors]', true)"
                        active-text="Allow multiple authors"
                        inactive-text="Do not allow multiple authors"
                    />
                </x-input.group>

                <x-input.group label="Restrict posting" help="You can set a specific role a user must have in order to use certain post types.">
                    <x-input.select name="roles" id="roles" class="w-full | md:w-2/3">
                        <option value="">No role restrictions</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Add Post Type</button>

                <a href="{{ route('post-types.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
