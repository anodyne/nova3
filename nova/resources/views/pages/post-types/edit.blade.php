@extends($meta->template)

@section('content')
    <x-page-header :title="$postType->name">
        <x-slot name="pretitle">
            <a href="{{ route('post-types.index') }}">Post Types</a>
        </x-slot>
    </x-page-header>

    <x-panel x-data="tabsList('details')">
        <div>
            <x-content-box class="sm:hidden">
                <select @change="switchTab($event.target.value)" aria-label="Selected tab" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base border-gray-6 focus:outline-none focus:ring focus:border-blue-7 transition ease-in-out duration-200 sm:text-sm rounded-md">
                    <option value="details">Details</option>
                    <option value="permissions">Fields</option>
                    <option value="users">Options</option>
                </select>
            </x-content-box>
            <div class="hidden sm:block">
                <div class="border-b border-gray-6 px-4 sm:px-6">
                    <nav class="-mb-px flex">
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-7 text-blue-11': isTab('details'), 'text-gray-9 hover:text-gray-11 hover:border-gray-6': isNotTab('details') }" @click.prevent="switchTab('details')">
                            Details
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-7 text-blue-11': isTab('fields'), 'text-gray-9 hover:text-gray-11 hover:border-gray-6': isNotTab('fields') }" @click.prevent="switchTab('fields')">
                            Fields
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none" :class="{ 'border-blue-7 text-blue-11': isTab('options'), 'text-gray-9 hover:text-gray-11 hover:border-gray-6': isNotTab('options') }" @click.prevent="switchTab('options')">
                            Options
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <x-form :action="route('post-types.update', $postType)" method="PUT" :divide="false" :space="false">
            <x-form.section title="Post Type Info" message="A post type defines how different types of story entries are displayed and used. Using post types, you can setup your writing features exactly how you want them for your game." x-show="isTab('details')">
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

            <x-form.section title="Fields" message="Post types control which fields are available when creating a post of that type. You can turn any of these fields on/off to suit your game's needs." x-show="isTab('fields')">
                @foreach ($fieldTypes as $fieldType)
                    <div x-data="{ '{{ $fieldType }}': {{ $postType->fields->{$fieldType}->enabled ? 'true' : 'false' }} }" class="px-4 py-5 bg-gray-2 rounded border border-gray-6 sm:p-6">
                        <div @toggle-changed="{{ $fieldType }} = $event.detail.value">
                            <x-input.toggle field="fields[{{ $fieldType }}][enabled]" :value="old('fields[{{ $fieldType }}][enabled]', $postType->fields->{$fieldType}->enabled)">
                                {{ ucfirst($fieldType) }} field
                            </x-input.toggle>
                        </div>

                        <div x-show="{{ $fieldType }}" class="mt-6 px-6 space-y-4">
                            <x-input.group>
                                <x-input.toggle field="fields[{{ $fieldType }}][validate]" :value="old('fields[{{ $fieldType }}][validate]', $postType->fields->{$fieldType}->validate)">
                                    Require value
                                </x-input.toggle>
                            </x-input.group>
                        </div>
                    </div>
                @endforeach
            </x-form.section>

            <x-form.section title="Options" message="Post types control the behavior of a post of that type with a wide range of options. You can turn any of these fields on/off to suit your game's needs." x-show="isTab('options')">
                <x-input.group>
                    <x-input.toggle field="options[notifyUsers]" :value="old('options[notifyUsers]', $postType->options->notifyUsers)">
                        Send notification to users
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="options[notifyDiscord]" :value="old('options[notifyDiscord]', true)">
                        Send notification to Discord
                    </x-input.toggle>

                    {{-- @if (! settings()->discord->storyPostsEnabled)
                        <x-slot name="help">
                            <span class="font-medium">Story post notifications for Discord is currently disabled.</span> You can change this setting, but it will not work until you have enabled sending story post notifications to Discord from the <a class="text-blue-9 hover:text-blue-10 transition ease-in-out duration-200" href="{{ route('settings.index', 'discord') }}">Discord settings</a>.
                        </x-slot>
                    @endif --}}
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="fields[includeInPostTracking]" :value="old('fields[includeInPostTracking]', $postType->options->includeInPostTracking)">
                        Include in post tracking
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="fields[multipleAuthors]" :value="$postType->options->multipleAuthors">
                        Allow multiple authors
                    </x-input.toggle>
                </x-input.group>

                <x-input.group label="Restrict posting" help="You can set a specific role a user must have in order to use certain post types.">
                    <x-input.select name="role_id" id="role_id" class="w-full md:w-2/3">
                        <option value="">No role restrictions</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @if ($postType->role_id == $role->id) selected @endif>{{ $role->display_name }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>
            </x-form.section>

            <x-form.footer class="mt-4 md:mt-8">
                <x-button type="submit" color="blue">Update Post Type</x-button>
                <x-link :href="route('post-types.index')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
