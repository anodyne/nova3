@use('Nova\Foundation\Enums\BasicStatus')
@use('Nova\Pages\Models\Page')
@use('Nova\Pages\Enums\PageVerb')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-heading>
            @can('viewAny', Page::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.pages.index')" variant="ghost" inset="right">
                        <span aria-hidden="true">←</span>
                        Back
                    </x-button>
                </x-slot>
            @endcan
        </x-page-heading>

        <x-form
            :action="route('admin.pages.update', $page)"
            x-data="{
                type: '{{ filled($page->resource) ? 'advanced' : 'basic' }}',
                verb: {{ Js::from($page->verb) }},
                resource: {{ Js::from($page->resource) }}
            }"
            x-init="$watch('type', (value) => {
                if (value === 'basic') {
                    verb = 'get';
                    resource = null;
                }
            })"
            method="PUT"
        >
            <x-fieldset>
                <x-fieldset.group constrained>
                    <x-radio.group x-model="type">
                        <x-radio
                            label="Basic page"
                            description="A simple page that uses the page builder to create the content of the page"
                            name="type"
                            value="basic"
                        />

                        <x-radio
                            label="Advanced page"
                            description="A page that requires a controller and code to create the content / action of the page"
                            name="type"
                            value="advanced"
                        />
                    </x-radio.group>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset x-show="type" x-cloak>
                <x-fieldset.group constrained>
                    <x-input label="Name" name="name" :value="old('name', $page->name)" />

                    <x-field label="URI" id="uri" :error="$errors->first('uri')">
                        <x-label>URI</x-label>

                        <x-input.group>
                            <x-input.group.prefix>
                                {{ str(url('/'))->replace('https://', '')->replace('http://', '')->append('/') }}
                            </x-input.group.prefix>
                            <x-input name="uri" :value="old('uri', $page->uri)" />
                        </x-input.group>
                    </x-field>

                    <x-input
                        label="Key"
                        description="The key must be a unique value to identify the page"
                        name="key"
                        :value="old('key', $page->key)"
                    />

                    <x-radio.group>
                        <x-radio
                            label="Public page"
                            description="A page that is accessible to any site visitor"
                            name="layout"
                            value="public"
                            :checked="old('layout', $page->layout === 'public')"
                        />

                        <x-radio
                            label="Admin page"
                            description="A page that is only accessible to authenticated users"
                            name="layout"
                            value="admin"
                            :checked="old('layout', $page->layout === 'admin')"
                        />
                    </x-radio.group>

                    <x-switch
                        label="Active"
                        description="Use caution when disabling pages, especially advanced pages, as doing so could cause your site to break"
                        name="status"
                        :checked="old('status', $page->status === BasicStatus::Active)"
                    />
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset x-show="type === 'advanced'" x-cloak>
                <x-fieldset.heading :icon="Tabler::Code" heading="Advanced page options">
                    <x-description>
                        Advanced pages allow you to do more complex things than the page builder. You will need to
                        create your controller, view files, and any supporting classes you need in order to continue.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-select label="Verb" name="verb" x-model="verb">
                        @foreach (PageVerb::toOptions() as $verb => $label)
                            <option value="{{ $verb }}" @selected($page->verb->value === $verb)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input
                        label="Resource"
                        description="The fully qualified class name of the controller"
                        name="resource"
                        x-model="resource"
                        :value="old('resource', $page->resource)"
                    />
                </x-fieldset.group>
            </x-fieldset>

            @if ($page->content_can_be_edited)
                <x-fieldset x-show="verb === 'get'" x-cloak>
                    <x-fieldset.heading :icon="Tabler::Blockquote" heading="Page content">
                        <x-description>Set the heading, sub-heading, and intro text for the page.</x-description>
                    </x-fieldset.heading>

                    <x-fieldset.group constrained>
                        <x-input label="Heading" name="heading" :value="old('heading', $page->heading)" />

                        <x-input label="Sub-heading" name="subheading" :value="old('subheading', $page->subheading)" />

                        <x-textarea label="Intro" name="intro" rows="5">
                            {{ old('intro', $page->intro) }}
                        </x-textarea>
                    </x-fieldset.group>
                </x-fieldset>
            @endif

            <x-fieldset x-show="verb === 'get'" x-cloak>
                <x-fieldset.heading :icon="Tabler::Seo" heading="SEO tools">
                    <x-description>
                        Customize your SEO settings for better placement in search results and more. This is most
                        important on pages that are publicly available to the world.
                    </x-description>
                </x-fieldset.heading>

                <x-fieldset.group constrained>
                    <x-input
                        label="Title"
                        description="Title is important for SEO and social sharing. You should use it to describe the content of the page and keep it under 60 characters."
                        name="seo_title"
                        :value="old('seo_title', $page->seo_title)"
                    />

                    <x-textarea
                        label="Description"
                        description="Search engines will read your description and display it in the search results. For best results, keep your description between 155 and 160 characters."
                        name="seo_description"
                        rows="3"
                    >
                        {{ old('seo_description', $page->seo_description) }}
                    </x-textarea>

                    <x-textarea
                        label="Keywords"
                        description="Keywords are the ideas and topics that define what your content is about. In terms of SEO, they’re the words and phrases that searchers enter into search engines to discover content."
                        name="seo_keywords"
                        rows="3"
                    >
                        {{ old('seo_keywords', $page->seo_keywords) }}
                    </x-textarea>

                    <x-field>
                        <x-label>Image</x-label>
                        <livewire:media-upload-image :model="$page" media-collection-name="seo-image" />
                    </x-field>
                </x-fieldset.group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" variant="primary">Update</x-button>
                <x-button :href="route('admin.pages.index')" variant="ghost">Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
