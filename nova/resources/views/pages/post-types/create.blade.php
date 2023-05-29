@extends($meta->template)

@section('content')
    <x-panel
        x-data="{ ...tabsList('details'), name: '{{ old('name', '') }}', key: '{{ old('key', '') }}', suggestKey: true }"
        x-init="$watch('name', value => {
            if (suggestKey) {
                key = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
            }
        })"
    >
        <x-panel.header title="Add a post type">
            <x-slot:actions>
                @can('viewAny', Nova\PostTypes\Models\PostType::class)
                    <x-button.text :href="route('post-types.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan
            </x-slot:actions>

            <div>
                <x-content-box class="sm:hidden">
                    <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                        <option value="details">Details</option>
                        <option value="permissions">Permissions</option>
                        <option value="users">Users</option>
                    </x-input.select>
                </x-content-box>
                <div class="hidden sm:block">
                    <x-content-box height="none">
                        <nav class="-mb-px flex">
                            <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('details'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('details') }" @click.prevent="switchTab('details')">
                                Details
                            </a>
                            <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('fields'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('fields') }" @click.prevent="switchTab('fields')">
                                Fields
                            </a>
                            <a href="#" class="whitespace-nowrap ml-8 first:ml-0 py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition" :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('options'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('options') }" @click.prevent="switchTab('options')">
                                Options
                            </a>
                        </nav>
                    </x-content-box>
                </div>
            </div>
        </x-panel.header>

        <x-form :action="route('post-types.store')" :divide="false" :space="false">
            <x-form.section title="Post Type Info" message="A post type defines how different types of story entries are displayed and used. Using post types, you can setup your writing features exactly how you want for your game." x-show="isTab('details')">
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
                    <x-input.radio label="In character" for="in_character" name="visibility" id="in_character" :value="old('visibility', 'in-character')" />

                    <span class="ml-6">
                        <x-input.radio label="Out of character" for="out_of_character" name="visibility" id="out_of_character" :value="old('visibility', 'out-of-character')" />
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

            <x-form.section title="Fields" message="Post types control which fields are available when creating a post of that type. You can turn any of these fields on/off to suit your game's needs." x-show="isTab('fields')" x-cloak>
                @foreach ($fieldTypes as $fieldType)
                    <x-content-box class="px-4 py-5 bg-gray-50 dark:bg-gray-700/50 rounded border border-gray-200 dark:border-gray-700 sm:p-6" x-data="{ '{{ $fieldType }}': true }">
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

            <x-form.section title="Options" message="Post types control the behavior of a post of that type with a wide range of options. You can turn any of these fields on/off to suit your game's needs." x-show="isTab('options')" x-cloak>
                <x-input.group>
                    <x-input.toggle field="options[notifiesUsers]" :value="old('options[notifiesUsers]', true)">
                        Send notification to users when published
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="options[includedInPostTracking]" :value="old('options[includedInPostTracking]', true)">
                        Include in post tracking
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="options[allowsMultipleAuthors]" :value="old('options[allowsMultipleAuthors]', true)">
                        Allow multiple authors
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="options[allowsCharacterAuthors]" :value="old('options[allowsCharacterAuthors]', true)">
                        Allow characters as authors
                    </x-input.toggle>
                </x-input.group>

                <x-input.group>
                    <x-input.toggle field="options[allowsUserAuthors]" :value="old('options[allowsUserAuthors]', true)">
                        Allow users as authors
                    </x-input.toggle>
                </x-input.group>

                <x-input.group label="Restrict posting" help="You can set a specific role a user must have in order to use certain post types.">
                    <x-input.select name="role_id" id="roles" class="w-full md:w-2/3">
                        <option value="">No role restrictions</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                    </x-input.select>
                </x-input.group>
            </x-form.section>

            <x-form.footer class="mt-4 md:mt-8">
                <x-button.filled type="submit" color="primary">Add</x-button.filled>
                <x-button.outline :href="route('post-types.index')" color="gray">Cancel</x-button.outline>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
