@use('Nova\Stories\Enums\PostTypeField')
@use('Nova\Stories\Enums\PostTypeVisibility')
@use('Nova\Stories\Models\PostType')

<x-admin-layout>
    <x-spacing
        x-data="{ name: '{{ old('name', '') }}', key: '{{ old('key', '') }}', suggestKey: true }"
        x-init="$watch('name', value => {
            if (suggestKey) {
                key = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
            }
        })"
        constrained
    >
        <x-page-heading>
            @can('viewAny', PostType::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.post-types.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <x-form :action="route('admin.post-types.store')" :space="false" class="mt-8">
            <x-tab.group>
                <x-slot name="tabs">
                    <x-tab name="details">Details</x-tab>
                    <x-tab name="fields">Fields</x-tab>
                    <x-tab name="options">Options</x-tab>
                </x-slot>

                <x-tab.panel name="details" class="space-y-12">
                    <x-fieldset>
                        <x-fieldset.group constrained>
                            <x-input label="Name" name="name" x-model="name" />

                            <x-input label="Key" name="key" x-model="key" x-on:change="suggestKey = false" />

                            <x-textarea label="Description" name="description" rows="3">
                                {{ old('description') }}
                            </x-textarea>

                            <x-input
                                label="Accent color"
                                description="When setting the accent color for your post type icon, keep in mind that it could be displayed on either a light or dark background"
                                type="color"
                                name="color"
                                :value="old('color')"
                            />

                            <x-field>
                                <x-label>Icon</x-label>
                                <livewire:icon-picker :selected="old('icon', '')" />
                            </x-field>
                        </x-fieldset.group>
                    </x-fieldset>

                    <x-fieldset>
                        <x-fieldset.heading :icon="Tabler::Eye" heading="Visibility">
                            <x-description>
                                When displayed on the public site, only in character posts will be visible. Out of
                                character posts will still be visible in the admin panel.
                            </x-description>
                        </x-fieldset.heading>

                        <x-radio.group name="visibility" variant="segmented" class="max-w-fit">
                            @foreach (PostTypeVisibility::cases() as $visibility)
                                <x-radio
                                    :label="$visibility->getLabel()"
                                    :value="$visibility->value"
                                    :checked="old('visibility')"
                                />
                            @endforeach
                        </x-radio.group>
                    </x-fieldset>

                    <x-switch label="Active" name="status" :checked="old('status')" align="left" />
                </x-tab.panel>

                <x-tab.panel name="fields" class="space-y-12">
                    <x-fieldset>
                        <x-fieldset.heading :icon="Tabler::Forms" heading="Fields">
                            <x-description>
                                Post types control which fields are available when creating a post of that type. You can
                                turn any of these fields on/off to suit your game’s needs.
                            </x-description>
                        </x-fieldset.heading>

                        <x-fieldset.group constrained>
                            @foreach (PostTypeField::cases() as $field)
                                <x-panel
                                    variant="well"
                                    x-data="{
                                        expanded: false,
                                        enabled: {{ Js::from(old('fields.' . $field->value . '.enabled', true)) }},
                                        required: {{ Js::from(old('fields.' . $field->value . '.required', false)) }}
                                    }"
                                >
                                    <x-panel.header class="cursor-pointer" x-on:click="expanded = !expanded">
                                        <x-slot name="title">
                                            <div class="flex items-center gap-x-1">
                                                <p>{{ $field->getLabel() }} field</p>
                                                <p class="text-danger-500 font-medium" x-show="required">*</p>
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
                                                <x-icon :name="Tabler::ChevronRight" size="md" />
                                            </div>
                                        </x-slot>
                                    </x-panel.header>

                                    <x-panel x-show="expanded" x-collapse hidden>
                                        <x-spacing.group divided>
                                            <x-panel.group.row class="*:w-full">
                                                @php
                                                    $enabledId = "field_enabled_{$field->value}";
                                                    $description = $field->canBeDisabled()
                                                        ? "Use the {$field->value} field for this post type"
                                                        : 'This field cannot be disabled';
                                                @endphp

                                                <x-switch
                                                    label="Enabled"
                                                    :$description
                                                    name="fields[{{ $field->value }}][enabled]"
                                                    x-model="enabled"
                                                    :disabled="! $field->canBeDisabled()"
                                                />
                                            </x-panel.group.row>

                                            <x-panel.group.row class="*:w-full">
                                                @php
                                                    $requiredId = "field_required_{$field->value}";
                                                    $description = $field->canBeRequired()
                                                        ? 'The field must have a value'
                                                        : 'The field cannot be required';
                                                @endphp

                                                <x-switch
                                                    label="Required"
                                                    :$description
                                                    name="fields[{{ $field->value }}][required]"
                                                    x-model="required"
                                                    :disabled="! $field->canBeRequired()"
                                                />
                                            </x-panel.group.row>
                                        </x-spacing.group>
                                    </x-panel>
                                </x-panel>
                            @endforeach
                        </x-fieldset.group>
                    </x-fieldset>
                </x-tab.panel>

                <x-tab.panel name="options" class="space-y-12">
                    <x-fieldset>
                        <x-fieldset.heading :icon="Tabler::Adjustments" heading="Options">
                            <x-description>
                                Post types control the behavior of a post of that type with a wide range of options. You
                                can turn any of these options on/off to suit your game’s needs.
                            </x-description>
                        </x-fieldset.heading>

                        <x-fieldset.group constrained>
                            <x-switch
                                label="Send notification to users when published"
                                name="options[notifiesUsers]"
                                :checked="old('options[notifiesUsers]', true)"
                            />

                            <x-switch
                                label="Include in post tracking stats"
                                name="options[includedInPostTracking]"
                                :checked="old('options[includedInPostTracking]', true)"
                            />

                            <x-switch
                                label="Allow multiple authors"
                                name="options[allowsMultipleAuthors]"
                                :checked="old('options[allowsMultipleAuthors]', true)"
                            />

                            <x-switch
                                label="Allow characters as authors"
                                name="options[allowsCharacterAuthors]"
                                :checked="old('options[allowsCharacterAuthors]', true)"
                            />

                            <x-switch
                                label="Allow users as authors"
                                name="options[allowsUserAuthors]"
                                :checked="old('options[allowsUserAuthors]', true)"
                            />

                            <x-switch
                                label="Show content in timeline view"
                                description="Use caution when enabling this for post types that have large amounts of content as there could be a negative impact on page performance. This works best for post types with small amounts of content."
                                name="options[showContentInTimelineView]"
                                :checked="old('options[showContentInTimelineView]', false)"
                            />

                            <x-select
                                label="Restrict posting"
                                description="You can set a specific role a user must have in order to use certain post types"
                                name="role_id"
                                class="w-full md:w-2/3"
                            >
                                <option value="">No role restrictions</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->display_name }}
                                    </option>
                                @endforeach
                            </x-select>

                            <x-select
                                label="Published post editing timeframe"
                                description="You can set how long after publishing authors can edit the post"
                                name="options[editTimeframe]"
                                class="w-full md:w-2/3"
                            >
                                @foreach ($editTimeframes as $timeframe => $text)
                                    <option value="{{ $timeframe }}">
                                        {{ $text }}
                                    </option>
                                @endforeach
                            </x-select>
                        </x-fieldset.group>
                    </x-fieldset>
                </x-tab.panel>
            </x-tab.group>

            <x-fieldset.controls class="mt-12">
                <x-button type="submit" variant="primary">Add</x-button>
                <x-button :href="route('admin.post-types.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
