@extends($meta->template)

@section('content')
    <x-panel x-data="tabsList('details')">
        <x-panel.header :title="$postType->name">
            <x-slot name="actions">
                @can('viewAny', Nova\Stories\Models\PostType::class)
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
            <x-form.section title="Post type info" x-show="isTab('details')">
                <x-slot name="message">
                    <x-text>
                        A post type defines how different types of story entries are displayed and used. Using post
                        types, you can setup your writing features exactly how you want for your game.
                    </x-text>
                </x-slot>

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
                    <livewire:icon-picker :selected="old('icon', $postType->icon ?? '')" />
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

                <div class="flex items-center gap-x-2.5">
                    <x-switch
                        name="status"
                        :value="old('status', $postType->status->value ?? 'active')"
                        on-value="active"
                        off-value="inactive"
                        id="status"
                    ></x-switch>
                    <x-fieldset.label for="status">Active</x-fieldset.label>
                </div>
            </x-form.section>

            <x-form.section title="Fields" x-show="isTab('fields')" x-cloak>
                <x-slot name="message">
                    <x-text>
                        Post types control which fields are available when creating a post of that type. You can turn
                        any of these fields on/off to suit your game's needs.
                    </x-text>
                </x-slot>

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
                                <div class="mt-6 border-t border-gray-950/10 pt-6 dark:border-white/5">
                                    @php($enabledId = "field_enabled_{$fieldType}")

                                    <x-switch.field x-on:toggle-switch-changed="enabled = !enabled">
                                        <x-fieldset.label :for="$enabledId">Enabled</x-fieldset.label>
                                        <x-fieldset.description>
                                            Use the {{ $fieldType }} field for this post type
                                        </x-fieldset.description>
                                        <x-switch
                                            name="fields[{{ $fieldType }}][enabled]"
                                            :id="$enabledId"
                                            :value="old('fields[{{ $fieldType }}][enabled]', $postType->fields->{$fieldType}->enabled)"
                                        ></x-switch>
                                    </x-switch.field>
                                </div>
                                <div class="mt-6 border-t border-gray-950/10 pt-6 dark:border-white/5">
                                    @php($requiredId = "field_required_{$fieldType}")

                                    <x-switch.field x-on:toggle-switch-changed="required = !required">
                                        <x-fieldset.label :for="$requiredId">Required</x-fieldset.label>
                                        <x-fieldset.description>The field must have a value</x-fieldset.description>
                                        <x-switch
                                            name="fields[{{ $fieldType }}][required]"
                                            :id="$requiredId"
                                            :value="old('fields[{{ $fieldType }}][required]', $postType->fields->{$fieldType}->required)"
                                        ></x-switch>
                                    </x-switch.field>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.section title="Options" x-show="isTab('options')" x-cloak>
                <x-slot name="message">
                    <x-text>
                        Post types control the behavior of a post of that type with a wide range of options. You can
                        turn any of these options on/off to suit your game's needs.
                    </x-text>
                </x-slot>

                <x-switch.group class="w-full max-w-md">
                    <x-switch.field>
                        <x-fieldset.label for="options_notifies_users">
                            Send notification to users when published
                        </x-fieldset.label>
                        <x-switch
                            name="options[notifiesUsers]"
                            id="options_notifies_users"
                            :value="old('options[notifiesUsers]', $postType->options->notifiesUsers)"
                        >
                            Send notification to users when published
                        </x-switch>
                    </x-switch.field>

                    <x-switch.field>
                        <x-fieldset.label for="options_included_in_post_tracking">
                            Include in post tracking stats
                        </x-fieldset.label>
                        <x-switch
                            name="options[includedInPostTracking]"
                            id="options_included_in_post_tracking"
                            :value="old('options[includedInPostTracking]', $postType->options->includedInPostTracking)"
                        ></x-switch>
                    </x-switch.field>

                    <x-switch.field>
                        <x-fieldset.label for="options_allow_multiple_authors">Allow multiple authors</x-fieldset.label>
                        <x-switch
                            name="options[allowsMultipleAuthors]"
                            id="options_allow_multiple_authors"
                            :value="old('options[allowsMultipleAuthors]', $postType->options->allowsMultipleAuthors)"
                        ></x-switch>
                    </x-switch.field>

                    <x-switch.field>
                        <x-fieldset.label for="options_allow_character_authors">
                            Allow characters as authors
                        </x-fieldset.label>
                        <x-switch
                            name="options[allowsCharacterAuthors]"
                            id="options_allow_character_authors"
                            :value="old('options[allowsCharacterAuthors]', $postType->options->allowsCharacterAuthors)"
                        ></x-switch>
                    </x-switch.field>

                    <x-switch.field>
                        <x-fieldset.label for="options_allow_user_authors">Allow users as authors</x-fieldset.label>
                        <x-switch
                            name="options[allowsUserAuthors]"
                            id="options_allow_user_authors"
                            :value="old('options[allowsUserAuthors]', $postType->options->allowsUserAuthors)"
                        ></x-switch>
                    </x-switch.field>

                    <x-switch.field>
                        <x-fieldset.label for="options_show_content_in_timeline">
                            Show content in timeline view
                        </x-fieldset.label>
                        <x-fieldset.description>
                            Use caution when enabling this for post types that have large amounts of content as there
                            could be a negative impact on page performance. This works best for post types with small
                            amounts of content.
                        </x-fieldset.description>
                        <x-switch
                            name="options[showContentInTimelineView]"
                            id="options_show_content_in_timeline"
                            :value="old('options[showContentInTimelineView]', $postType->options->showContentInTimelineView)"
                        ></x-switch>
                    </x-switch.field>
                </x-switch.group>

                <x-input.group
                    label="Restrict posting"
                    help="You can set a specific role a user must have in order to use certain post types"
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

                <x-input.group
                    label="Published post editing timeframe"
                    help="You can set how long after publishing authors can edit the post"
                >
                    <x-input.select name="options[editTimeframe]" id="editTimeframe" class="w-full md:w-2/3">
                        @foreach ($editTimeframes as $timeframe => $text)
                            <option
                                value="{{ $timeframe }}"
                                @selected($postType->options->editTimeframe->value === $timeframe)
                            >
                                {{ $text }}
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
