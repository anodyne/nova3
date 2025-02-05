@use('Nova\Stories\Enums\PostTypeVisibility')
@use('Nova\Stories\Models\PostType')

<x-admin-layout>
    <x-spacing
        x-data="{ ...tabsList('details'), name: '{{ old('name', '') }}', key: '{{ old('key', '') }}', suggestKey: true }"
        x-init="$watch('name', value => {
            if (suggestKey) {
                key = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
            }
        })"
        constrained
    >
        <x-page-header>
            @can('viewAny', PostType::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.post-types.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-tab.group name="post-type">
            <x-tab.heading name="details">Details</x-tab.heading>
            <x-tab.heading name="fields">Fields</x-tab.heading>
            <x-tab.heading name="options">Options</x-tab.heading>
        </x-tab.group>

        <x-form :action="route('admin.post-types.store')" :space="false" class="mt-8">
            <div x-show="isTab('details')" class="space-y-12">
                <x-fieldset>
                    <x-fieldset.field-group constrained>
                        <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                            <x-input.text x-model="name" data-cy="name" />
                        </x-fieldset.field>

                        <x-fieldset.field label="Key" id="key" name="key" :error="$errors->first('key')">
                            <x-input.text x-model="key" x-on:change="suggestKey = false" data-cy="key" />
                        </x-fieldset.field>

                        <x-fieldset.field label="Description" id="description" name="description">
                            <x-input.textarea data-cy="description" rows="3">
                                {{ old('description') }}
                            </x-input.textarea>
                        </x-fieldset.field>

                        <x-panel variant="well">
                            <x-panel.header
                                title="Accent color"
                                description="When setting the accent color for your post type icon, keep in mind that it could be displayed on either a light or dark background."
                            ></x-panel.header>

                            <x-panel>
                                <x-spacing size="md">
                                    <livewire:advanced-color-picker field="color" :state="old('color', '#0ea5e9')" />
                                </x-spacing>
                            </x-panel>
                        </x-panel>

                        <x-fieldset.field label="Icon" id="icon" name="icon">
                            <livewire:icon-picker :selected="old('icon', '')" />
                        </x-fieldset.field>
                    </x-fieldset.field-group>
                </x-fieldset>

                <x-fieldset>
                    <x-fieldset.heading>
                        <x-icon name="show"></x-icon>
                        <x-fieldset.legend>Visibility</x-fieldset.legend>
                        <x-fieldset.description>
                            When displayed on the public site, only in character posts will be visible. Out of character
                            posts will still be visible in the admin panel.
                        </x-fieldset.description>
                    </x-fieldset.heading>

                    <x-radio.group>
                        @foreach (PostTypeVisibility::cases() as $visibility)
                            <x-radio.field>
                                <x-fieldset.label for="{{ $visibility->htmlId() }}">
                                    {{ $visibility->getLabel() }}
                                </x-fieldset.label>
                                <x-radio
                                    id="{{ $visibility->htmlId() }}"
                                    name="visibility"
                                    value="{{ $visibility->value }}"
                                    :checked="old('visibility')"
                                ></x-radio>
                            </x-radio.field>
                        @endforeach
                    </x-radio.group>
                </x-fieldset>

                <div class="flex items-center gap-x-2.5">
                    <x-switch
                        name="status"
                        :value="old('status', 'active')"
                        on-value="active"
                        off-value="inactive"
                        id="status"
                    ></x-switch>
                    <x-fieldset.label for="status">Active</x-fieldset.label>
                </div>
            </div>

            <div x-show="isTab('fields')" class="space-y-12" x-cloak>
                <x-fieldset>
                    <x-fieldset.heading>
                        <x-icon name="form"></x-icon>
                        <x-fieldset.legend>Fields</x-fieldset.legend>
                        <x-fieldset.description>
                            Post types control which fields are available when creating a post of that type. You can
                            turn any of these fields on/off to suit your game’s needs.
                        </x-fieldset.description>
                    </x-fieldset.heading>

                    <x-fieldset.field-group constrained>
                        @foreach ($fieldTypes as $fieldType)
                            <x-panel
                                variant="well"
                                x-data="{
                                    expanded: false,
                                    enabled: true,
                                    required: false,
                                }"
                            >
                                <x-panel.header class="cursor-pointer" x-on:click="expanded = !expanded">
                                    <x-slot name="title">
                                        <div class="flex items-center gap-x-1">
                                            <p>{{ str($fieldType)->ucfirst() }} field</p>
                                            <p class="font-medium text-danger-500" x-show="required">*</p>
                                        </div>
                                    </x-slot>

                                    <x-slot name="badge">
                                        <x-badge color="success" x-show="enabled">Enabled</x-badge>
                                        <x-badge color="gray" x-show="!enabled">Disabled</x-badge>
                                    </x-slot>

                                    <x-slot name="actions">
                                        <div
                                            class="shrink-0 text-gray-400 transition-transform duration-200 dark:text-gray-500"
                                            x-bind:class="{
                                                'rotate-90': expanded,
                                            }"
                                        >
                                            <x-icon name="chevron-right" size="md"></x-icon>
                                        </div>
                                    </x-slot>
                                </x-panel.header>

                                <x-panel
                                    class="divide-y divide-gray-950/5 dark:divide-white/5"
                                    x-show="expanded"
                                    x-collapse
                                    x-cloak
                                >
                                    <x-spacing size="row">
                                        @php($enabledId = "field_enabled_{$fieldType}")

                                        <x-switch.field x-on:toggle-switch-changed="enabled = !enabled">
                                            <x-fieldset.label :for="$enabledId">Enabled</x-fieldset.label>
                                            <x-fieldset.description>
                                                Use the {{ $fieldType }} field for this post type
                                            </x-fieldset.description>
                                            <x-switch
                                                name="fields[{{ $fieldType }}][enabled]"
                                                :id="$enabledId"
                                                :value="old('fields[{{ $fieldType }}][enabled]', true)"
                                            ></x-switch>
                                        </x-switch.field>
                                    </x-spacing>

                                    <x-spacing size="row">
                                        @php($requiredId = "field_required_{$fieldType}")

                                        <x-switch.field x-on:toggle-switch-changed="required = !required">
                                            <x-fieldset.label :for="$requiredId">Required</x-fieldset.label>
                                            <x-fieldset.description>The field must have a value</x-fieldset.description>
                                            <x-switch
                                                name="fields[{{ $fieldType }}][required]"
                                                :id="$requiredId"
                                                :value="old('fields[{{ $fieldType }}][required]', false)"
                                            ></x-switch>
                                        </x-switch.field>
                                    </x-spacing>
                                </x-panel>
                            </x-panel>
                        @endforeach
                    </x-fieldset.field-group>
                </x-fieldset>
            </div>

            <div x-show="isTab('options')" class="space-y-12" x-cloak>
                <x-fieldset>
                    <x-fieldset.heading>
                        <x-icon name="preferences"></x-icon>
                        <x-fieldset.legend>Options</x-fieldset.legend>
                        <x-fieldset.description>
                            Post types control the behavior of a post of that type with a wide range of options. You can
                            turn any of these options on/off to suit your game’s needs.
                        </x-fieldset.description>
                    </x-fieldset.heading>

                    <x-fieldset.field-group constrained>
                        <x-switch.group class="w-full max-w-md">
                            <x-switch.field>
                                <x-fieldset.label for="options_notifies_users">
                                    Send notification to users when published
                                </x-fieldset.label>
                                <x-switch
                                    name="options[notifiesUsers]"
                                    id="options_notifies_users"
                                    :value="old('options[notifiesUsers]', true)"
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
                                    :value="old('options[includedInPostTracking]', true)"
                                ></x-switch>
                            </x-switch.field>

                            <x-switch.field>
                                <x-fieldset.label for="options_allow_multiple_authors">
                                    Allow multiple authors
                                </x-fieldset.label>
                                <x-switch
                                    name="options[allowsMultipleAuthors]"
                                    id="options_allow_multiple_authors"
                                    :value="old('options[allowsMultipleAuthors]', true)"
                                ></x-switch>
                            </x-switch.field>

                            <x-switch.field>
                                <x-fieldset.label for="options_allow_character_authors">
                                    Allow characters as authors
                                </x-fieldset.label>
                                <x-switch
                                    name="options[allowsCharacterAuthors]"
                                    id="options_allow_character_authors"
                                    :value="old('options[allowsCharacterAuthors]', true)"
                                ></x-switch>
                            </x-switch.field>

                            <x-switch.field>
                                <x-fieldset.label for="options_allow_user_authors">
                                    Allow users as authors
                                </x-fieldset.label>
                                <x-switch
                                    name="options[allowsUserAuthors]"
                                    id="options_allow_user_authors"
                                    :value="old('options[allowsUserAuthors]', true)"
                                ></x-switch>
                            </x-switch.field>

                            <x-switch.field>
                                <x-fieldset.label for="options_show_content_in_timeline">
                                    Show content in timeline view
                                </x-fieldset.label>
                                <x-fieldset.description>
                                    Use caution when enabling this for post types that have large amounts of content as
                                    there could be a negative impact on page performance. This works best for post types
                                    with small amounts of content.
                                </x-fieldset.description>
                                <x-switch
                                    name="options[showContentInTimelineView]"
                                    id="options_show_content_in_timeline"
                                    :value="old('options[showContentInTimelineView]', false)"
                                ></x-switch>
                            </x-switch.field>
                        </x-switch.group>

                        <x-fieldset.field
                            label="Restrict posting"
                            description="You can set a specific role a user must have in order to use certain post types"
                            name="role_id"
                            id="roles"
                        >
                            <x-select class="w-full md:w-2/3">
                                <option value="">No role restrictions</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                                @endforeach
                            </x-select>
                        </x-fieldset.field>

                        <x-fieldset.field
                            label="Published post editing timeframe"
                            description="You can set how long after publishing authors can edit the post"
                            name="options[editTimeframe]"
                            id="editTimeframe"
                        >
                            <x-select class="w-full md:w-2/3">
                                @foreach ($editTimeframes as $timeframe => $text)
                                    <option
                                        value="{{ $timeframe }}"
                                        @selected(old('options[editTimeframe]') === $timeframe)
                                    >
                                        {{ $text }}
                                    </option>
                                @endforeach
                            </x-select>
                        </x-fieldset.field>
                    </x-fieldset.field-group>
                </x-fieldset>
            </div>

            <x-fieldset.controls class="mt-12">
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('admin.post-types.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
