@use('Nova\Menus\Enums\LinkTarget')
@use('Nova\Menus\Enums\LinkType')
@use('Nova\Menus\Models\MenuItem')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', MenuItem::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.menu-items.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <x-form :action="route('admin.menu-items.update', $menuItem)" method="PUT">
            <x-fieldset>
                <x-fieldset.group
                    x-data="{ linkType: {{ Js::from(old('link_type', $menuItem->link_type->value)) }} }"
                    constrained
                >
                    <x-radio.group x-model="linkType">
                        <x-radio
                            label="Link to a Nova page"
                            description="Choose a Nova page to link to"
                            name="link_type"
                            :value="LinkType::Page->value"
                        />

                        <x-radio
                            label="Link to a URL"
                            description="Create a link directly to a URL"
                            name="link_type"
                            :value="LinkType::Url->value"
                        />
                    </x-radio.group>

                    <x-input label="Label" name="label" :value="old('label', $menuItem->label)" />

                    <x-select
                        label="Page"
                        description="You can only choose pages intended for the public site to link to"
                        name="page_id"
                        x-show="linkType === 'page'"
                        x-cloak
                    >
                        <option value="">Do not use a page</option>
                        @foreach ($pages as $page)
                            <option
                                value="{{ $page->id }}"
                                @selected(old('page_id', $menuItem->page_id) === $page->id)
                            >
                                {{ $page->name }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-field x-show="linkType === 'url'" x-cloak>
                        <x-label>URL</x-label>
                        <x-input name="url" :value="old('url', $menuItem->url)" />
                    </x-field>

                    <x-select label="Open in" name="target">
                        @foreach (LinkTarget::toOptions() as $value => $target)
                            <option
                                value="{{ $value }}"
                                @selected(old('target', $menuItem->target->value === $value))
                            >
                                {{ $target }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-field>
                        <x-label>Icon</x-label>
                        <div>
                            <livewire:icon-picker :selected="old('icon', $menuItem->icon)" />
                        </div>
                    </x-field>

                    <x-select
                        label="Parent menu item"
                        description="You can nest menu items and create a simple dropdown menu (one level deep only) by selecting a parent menu item"
                        name="parent_id"
                    >
                        <option value="">No parent menu item</option>
                        @foreach ($parentMenuItems as $parentItem)
                            <option
                                value="{{ $parentItem->id }}"
                                @selected(old('parent_id', $menuItem->parent_id) === $parentItem->id)
                            >
                                {{ $parentItem->label }}
                            </option>
                        @endforeach
                    </x-select>

                    <div class="flex items-center gap-x-2.5">
                        <x-switch
                            name="status"
                            :value="old('status', $menuItem->status->value ?? 'active')"
                            on-value="active"
                            off-value="inactive"
                            id="status"
                        ></x-switch>
                        <x-label for="status">Active</x-label>
                    </div>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.menu-items.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
