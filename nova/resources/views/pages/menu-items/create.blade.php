@use('Nova\Menus\Enums\LinkTarget')
@use('Nova\Menus\Enums\LinkType')
@use('Nova\Menus\Models\MenuItem')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', MenuItem::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.menu-items.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.menu-items.store')">
            <x-fieldset x-data="{ linkType: null }">
                <x-fieldset.field-group constrained>
                    <x-radio.group>
                        <x-radio.field>
                            <x-fieldset.label for="link_page">Link to a Nova page</x-fieldset.label>
                            <x-fieldset.description>Choose a Nova page to link to</x-fieldset.description>
                            <x-radio
                                id="link_page"
                                name="link_type"
                                value="{{ LinkType::Page->value }}"
                                x-model="linkType"
                            ></x-radio>
                        </x-radio.field>

                        <x-radio.field>
                            <x-fieldset.label for="link_url">Link to a URL</x-fieldset.label>
                            <x-fieldset.description>Create a link directly to a URL</x-fieldset.description>
                            <x-radio
                                id="link_url"
                                name="link_type"
                                value="{{ LinkType::Url->value }}"
                                x-model="linkType"
                            ></x-radio>
                        </x-radio.field>
                    </x-radio.group>
                </x-fieldset.field-group>

                <x-fieldset.field-group x-show="linkType !== null" x-cloak constrained>
                    <x-fieldset.field label="Label" id="label" name="label" :error="$errors->first('label')">
                        <x-input.text :value="old('label')" data-cy="label" />
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Page"
                        description="You can only choose pages intended for the public site to link to"
                        id="page"
                        name="page"
                        :error="$errors->first('page')"
                        x-show="linkType === 'page'"
                        x-cloak
                    >
                        <x-select>
                            <option value="">Do not use a page</option>
                            @foreach ($pages as $page)
                                <option value="{{ $page->id }}">{{ $page->name }}</option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="URL"
                        id="url"
                        name="url"
                        :error="$errors->first('url')"
                        x-show="linkType === 'url'"
                        x-cloak
                    >
                        <x-input.text :value="old('url')" data-cy="url" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Open in" id="target" name="target" :error="$errors->first('target')">
                        <x-select>
                            @foreach (LinkTarget::toOptions() as $value => $target)
                                <option value="{{ $value }}">{{ $target }}</option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>

                    <x-fieldset.field label="Icon" name="icon" id="icon">
                        <x-slot name="description">
                            You have access to the full
                            <x-text.link href="https://tabler.io/icons" target="_blank">Tabler icon set</x-text.link>
                            for this icon. You can find an icon you and want and enter its name in this field. If you
                            want to use a filled variant of an icon, append
                            <code>-filled</code>
                            to the end of the icon name.
                        </x-slot>

                        <x-input.text :value="old('icon')" data-cy="icon" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Parent menu item" name="parent_id" id="parent_id">
                        <x-slot name="description">
                            You can nest menu items and create a simple dropdown menu (one level deep only) by selecting
                            a parent menu item
                        </x-slot>

                        <x-select>
                            <option value="">No parent menu item</option>
                            @foreach ($parentMenuItems as $parentItem)
                                <option value="{{ $parentItem->id }}">{{ $parentItem->label }}</option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>

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
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('admin.menu-items.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
