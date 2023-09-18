@extends($meta->template)

@section('content')
    <x-panel x-data="tabsList('details')">
        <x-panel.header :title="$postType->name">
            <x-slot name="actions">
                @can('viewAny', Nova\PostTypes\Models\PostType::class)
                    <x-button.text :href="route('post-types.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan
            </x-slot>

            <div>
                <x-content-box class="sm:hidden">
                    <x-input.select @change="switchTab($event.target.value)" aria-label="Selected tab">
                        <option value="details">Details</option>
                        <option value="fields">Fields</option>
                        <option value="options">Options</option>
                    </x-input.select>
                </x-content-box>
                <div class="hidden sm:block">
                    <x-content-box height="none">
                        <nav class="-mb-px flex">
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('details'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('details') }"
                                x-on:click.prevent="switchTab('details')"
                            >
                                Details
                            </a>
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('fields'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('fields') }"
                                x-on:click.prevent="switchTab('fields')"
                            >
                                Fields
                            </a>
                            <a
                                href="#"
                                class="ml-8 whitespace-nowrap border-b-2 px-1 py-4 text-sm font-medium transition first:ml-0 focus:outline-none"
                                :class="{ 'border-primary-500 text-primary-600 dark:text-primary-500': isTab('options'), 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-400 dark:hover:border-gray-500': isNotTab('options') }"
                                x-on:click.prevent="switchTab('options')"
                            >
                                Options
                            </a>
                        </nav>
                    </x-content-box>
                </div>
            </div>
        </x-panel.header>

        <x-form :action="route('post-types.update', $postType)" method="PUT" :divide="false" :space="false">
            <x-form.section
                title="Post Type Info"
                message="A post type defines how different types of story entries are displayed and used. Using post types, you can setup your writing features exactly how you want for your game."
                x-show="isTab('details')"
            >
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $postType->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Key" for="key" :error="$errors->first('key')">
                    <x-input.text id="key" name="key" :value="old('key', $postType->key)" data-cy="key" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="3">
                        {{ old('description', $postType->description) }}
                    </x-input.textarea>
                </x-input.group>

                <x-input.group
                    label="Accent Color"
                    for="color"
                    help="When setting the accent color for your post type icon, keep in mind that it could be displayed on either a light or dark background."
                    :error="$errors->first('color')"
                >
                    <x-input.color name="color" id="color" :value="old('color', $postType->color)"></x-input.color>
                </x-input.group>

                <x-input.group label="Icon" for="icon">
                    <livewire:icon-picker :selected="old('icon', $postType->icon)" />
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

                <x-input.group :error="$errors->first('status')">
                    <x-switch-toggle
                        name="status"
                        :value="old('status', $postType->status ?? 'active')"
                        on-value="active"
                        off-value="inactive"
                    >
                        Active
                    </x-switch-toggle>
                </x-input.group>
            </x-form.section>

            <x-form.section
                title="Fields"
                message="Post types control which fields are available when creating a post of that type. You can turn any of these fields on/off to suit your game's needs."
                x-show="isTab('fields')"
                x-cloak
            >
                <div class="space-y-4">
                    @foreach ($fieldTypes as $fieldType)
                        <div
                            x-data="{
                                expanded: false,
                                enabled: @js($postType->fields->{$fieldType}->enabled),
                                required: @js($postType->fields->{$fieldType}->required),
                            }"
                            class="rounded-lg px-6 py-4"
                            :class="{
                                'shadow-md ring-1 ring-inset ring-gray-950/10 dark:bg-gray-800 dark:ring-white/5 dark:shadow-lg': expanded,
                                'transition hover:bg-gray-100 dark:hover:bg-gray-800': ! expanded,
                            }"
                        >
                            <button
                                type="button"
                                class="flex w-full appearance-none items-center justify-between"
                                x-on:click="expanded = !expanded"
                            >
                                <div class="flex items-center space-x-1">
                                    <h3 class="text-left text-base font-semibold text-gray-900 dark:text-white">
                                        {{ str($fieldType)->ucfirst() }} field
                                    </h3>
                                    <p class="font-medium text-danger-500" x-show="required">*</p>
                                </div>
                                <div class="ml-8 flex shrink-0 items-center space-x-3">
                                    <x-badge color="success" x-show="enabled">Enabled</x-badge>
                                    <x-badge color="gray" x-show="!enabled">Disabled</x-badge>

                                    <x-icon
                                        name="add"
                                        size="md"
                                        class="text-gray-400 dark:text-gray-500"
                                        x-show="!expanded"
                                    ></x-icon>
                                    <x-icon
                                        name="remove"
                                        size="md"
                                        class="text-gray-400 dark:text-gray-500"
                                        x-show="expanded"
                                    ></x-icon>
                                </div>
                            </button>

                            <div x-show="expanded" x-collapse x-cloak>
                                <div
                                    class="mt-6 flex justify-between border-t border-gray-900/10 pt-6 dark:border-white/5"
                                >
                                    <div class="space-y-0.5">
                                        <h3 class="text-base font-medium text-gray-700 dark:text-gray-200">Enable</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Use the {{ $fieldType }} field for this post type
                                        </p>
                                    </div>
                                    <div
                                        class="ml-8 shrink-0 pt-0.5"
                                        x-on:toggle-switch-changed="enabled = !enabled"
                                    >
                                        <x-switch-toggle
                                            name="fields[{{ $fieldType }}][enabled]"
                                            :value="old('fields[{{ $fieldType }}][enabled]', $postType->fields->{$fieldType}->enabled)"
                                        ></x-switch-toggle>
                                    </div>
                                </div>
                                <div
                                    class="mt-6 flex justify-between border-t border-gray-900/10 pt-6 dark:border-white/5"
                                >
                                    <div class="space-y-0.5">
                                        <h3 class="text-base font-medium text-gray-700 dark:text-gray-200">Require</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            The field must have a value
                                        </p>
                                    </div>
                                    <div
                                        class="ml-8 shrink-0 pt-0.5"
                                        x-on:toggle-switch-changed="required = !required"
                                    >
                                        <x-switch-toggle
                                            name="fields[{{ $fieldType }}][required]"
                                            :value="old('fields[{{ $fieldType }}][required]', $postType->fields->{$fieldType}->required)"
                                        ></x-switch-toggle>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.section
                title="Options"
                message="Post types control the behavior of a post of that type with a wide range of options. You can turn any of these fields on/off to suit your game's needs."
                x-show="isTab('options')"
                x-cloak
            >
                <x-input.group>
                    <x-switch-toggle
                        name="options[notifiesUsers]"
                        :value="old('options[notifiesUsers]', $postType->options->notifiesUsers)"
                    >
                        Send notification to users when published
                    </x-switch-toggle>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle
                        name="options[includedInPostTracking]"
                        :value="old('options[includedInPostTracking]', $postType->options->includedInPostTracking)"
                    >
                        Include in post tracking stats
                    </x-switch-toggle>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle
                        name="options[allowsMultipleAuthors]"
                        :value="$postType->options->allowsMultipleAuthors"
                    >
                        Allow multiple authors
                    </x-switch-toggle>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle
                        name="options[allowsCharacterAuthors]"
                        :value="$postType->options->allowsCharacterAuthors"
                    >
                        Allow characters as authors
                    </x-switch-toggle>
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle name="options[allowsUserAuthors]" :value="$postType->options->allowsUserAuthors">
                        Allow users as authors
                    </x-switch-toggle>
                </x-input.group>

                <x-input.group
                    label="Restrict posting"
                    help="You can set a specific role a user must have in order to use certain post types."
                >
                    <x-input.select name="role_id" id="role_id" class="w-full md:w-2/3">
                        <option value="">No role restrictions</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected($postType->role_id === $role->id)>
                                {{ $role->display_name }}
                            </option>
                        @endforeach
                    </x-input.select>
                </x-input.group>
            </x-form.section>

            <x-form.footer class="mt-4 md:mt-8">
                <x-button.filled type="submit" color="primary">Update</x-button.filled>
                <x-button.filled :href="route('post-types.index')" color="neutral">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
