@extends($meta->template)

@section('content')
    <x-page-header title="Add Post Type">
        <x-slot:pretitle>
            <a href="{{ route('post-types.index') }}">Post Types</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-panel
        x-data="{ ...tabsList('details'), name: '', key: '', suggestKey: true }"
        x-init="$watch('name', value => {
            if (suggestKey) {
                key = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
            }
        })"
    >
        <div>
            <x-content-box class="sm:hidden">
                <select @change="switchTab($event.target.value)" aria-label="Selected tab" class="mt-1 form-select bg-white block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring focus:border-blue-400 transition ease-in-out duration-200 sm:text-sm rounded-md">
                    <option value="details">Details</option>
                    <option value="permissions">Fields</option>
                    <option value="users">Options</option>
                </select>
            </x-content-box>
            <div class="hidden sm:block">
                <x-content-box height="none" class="border-b border-gray-200 dark:border-gray-200/10">
                    <nav class="-mb-px flex">
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none transition" :class="{ 'border-blue-400 text-blue-500': isTab('details'), 'text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500': isNotTab('details') }" @click.prevent="switchTab('details')">
                            Details
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none transition" :class="{ 'border-blue-400 text-blue-500': isTab('fields'), 'text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500': isNotTab('fields') }" @click.prevent="switchTab('fields')">
                            Fields
                        </a>
                        <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 border-transparent font-medium text-sm focus:outline-none transition" :class="{ 'border-blue-400 text-blue-500': isTab('options'), 'text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-500': isNotTab('options') }" @click.prevent="switchTab('options')">
                            Options
                        </a>
                    </nav>
                </x-content-box>
            </div>
        </div>

        <x-form :action="route('post-types.store')" :divide="false" :space="false">
            <x-form.section title="Post Type Info" message="A post type defines how different types of story entries are displayed and used. Using post types, you can setup your writing features exactly how you want them for your game." x-show="isTab('details')">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text x-model="name" id="name" name="name" data-cy="name" />
                </x-input.group>

                <x-input.group label="Key" for="key" :error="$errors->first('key')">
                    <x-input.text x-model="key" @change="suggestKey = false" id="key" name="key" data-cy="key" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="3">{{ old('description') }}</x-input.textarea>
                </x-input.group>

                <x-input.group
                    label="Accent Color"
                    for="color"
                    help="When setting the accent color for your post type icon, keep in mind that it could be displayed on either a light or dark background."
                    :error="$errors->first('color')"
                >
                    <x-input.color name="color" id="color" :value="old('color', '#0ea5e9')"></x-input.color>
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
                        field="status"
                        :value="old('status', 'active')"
                        active-value="active"
                        inactive-value="inactive"
                    >
                        Active
                    </x-input.toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section title="Fields" message="Post types control which fields are available when creating a post of that type. You can turn any of these fields on/off to suit your game's needs." x-show="isTab('fields')">
                @foreach ($fieldTypes as $fieldType)
                    <x-content-box class="px-4 py-5 bg-gray-50 dark:bg-gray-700/50 rounded border border-gray-200 dark:border-gray-200/10 sm:p-6" x-data="{ '{{ $fieldType }}': true }">
                        <div @toggle-changed="{{ $fieldType }} = $event.detail.value">
                            <x-input.toggle field="fields[{{ $fieldType }}][enabled]" :value="old('fields[{{ $fieldType }}][enabled]', true)">
                                Show the {{ $fieldType }} field
                            </x-input.toggle>
                        </div>

                        <div x-show="{{ $fieldType }}" class="mt-6 px-6 space-y-4">
                            <x-input.group>
                                <x-input.toggle field="fields[{{ $fieldType }}][required]" :value="old('fields[{{ $fieldType }}][required]', false)">
                                    Required to have a value
                                </x-input.toggle>
                            </x-input.group>
                        </div>
                    </x-content-box>
                @endforeach
            </x-form.section>

            <x-form.section title="Options" message="Post types control the behavior of a post of that type with a wide range of options. You can turn any of these fields on/off to suit your game's needs." x-show="isTab('options')">
                <x-input.group>
                    <x-input.toggle field="options[notifyUsers]" :value="old('options[notifyUsers]', true)">
                        Send notification to users
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="options[includeInPostTracking]" :value="old('options[includeInPostTracking]', true)">
                        Include in post tracking
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="options[multipleAuthors]" :value="old('options[multipleAuthors]', true)">
                        Allow multiple authors
                    </x-input.toggle>
                </x-input.group>

                <x-input.group label="Restrict posting" help="You can set a specific role a user must have in order to use certain post types.">
                    <x-input.select name="roles" id="roles" class="w-full md:w-2/3">
                        <option value="">No role restrictions</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>
            </x-form.section>

            <x-form.footer class="mt-4 md:mt-8">
                <x-button type="submit" color="blue">Add Post Type</x-button>
                <x-link :href="route('post-types.index')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
