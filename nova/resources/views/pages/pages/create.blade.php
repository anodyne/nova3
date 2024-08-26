@extends($meta->template)

@use('Nova\Pages\Models\Page')
@use('Nova\Pages\Enums\PageVerb')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Add a new page</x-slot>

            <x-slot name="actions">
                @can('viewAny', Page::class)
                    <x-button :href="route('admin.pages.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form
            :action="route('admin.pages.store')"
            x-data="{
                type: null,
                verb: 'get',
                resource: null
            }"
            x-init="$watch('type', (value) => {
                if (value === 'basic') {
                    verb = 'get';
                    resource = null;
                }
            })"
        >
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-radio.group>
                        <x-radio.field>
                            <x-fieldset.label for="type_basic">Basic page</x-fieldset.label>
                            <x-fieldset.description>
                                A simple page that uses the page builder to create the content of the page.
                            </x-fieldset.description>
                            <x-radio id="type_basic" name="uri" value="basic" x-model="type"></x-radio>
                        </x-radio.field>

                        <x-radio.field>
                            <x-fieldset.label for="type_advanced">Advanced page</x-fieldset.label>
                            <x-fieldset.description>
                                A page that requires a controller and code to create the content / action of the page.
                            </x-fieldset.description>
                            <x-radio id="type_advanced" name="uri" value="advanced" x-model="type"></x-radio>
                        </x-radio.field>
                    </x-radio.group>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset x-show="type" x-cloak>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                        <x-input.text :value="old('name')" data-cy="name" />
                    </x-fieldset.field>

                    <x-fieldset.field label="URI" id="uri" name="uri" :error="$errors->first('uri')">
                        <div class="flex items-center gap-x-2" data-slot="control">
                            <x-text>{{ url('/') }}/</x-text>
                            <x-input.text :value="old('uri')" data-cy="uri" />
                        </div>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Key"
                        description="The key must be a unique value to identify the page"
                        id="key"
                        name="key"
                        :error="$errors->first('key')"
                    >
                        <x-input.text :value="old('key')" data-cy="key" />
                    </x-fieldset.field>

                    <x-radio.group>
                        <x-radio.field>
                            <x-fieldset.label for="layout_public">Public page</x-fieldset.label>
                            <x-fieldset.description>
                                A page that is accessible to any site visitor
                            </x-fieldset.description>
                            <x-radio id="layout_public" name="layout" value="public"></x-radio>
                        </x-radio.field>

                        <x-radio.field>
                            <x-fieldset.label for="layout_admin">Admin page</x-fieldset.label>
                            <x-fieldset.description>
                                A page that is only accessible to authenticated users
                            </x-fieldset.description>
                            <x-radio id="layout_admin" name="layout" value="admin"></x-radio>
                        </x-radio.field>
                    </x-radio.group>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset x-show="type === 'advanced'" x-cloak>
                <x-fieldset.heading>
                    <x-icon name="code"></x-icon>
                    <x-fieldset.legend>Advanced page options</x-fieldset.legend>
                    <x-fieldset.description>
                        Advanced pages allow you to do more complex things than the page builder. You will need to
                        create your controller, view files, and any supporting classes you need in order to continue.
                    </x-fieldset.description>
                </x-fieldset.heading>

                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Verb" id="verb" name="verb" :error="$errors->first('verb')">
                        <x-select x-model="verb">
                            @foreach (PageVerb::toOptions() as $verb => $label)
                                <option value="{{ $verb }}">{{ $label }}</option>
                            @endforeach
                        </x-select>
                    </x-fieldset.field>

                    <x-fieldset.field
                        label="Resource"
                        description="The fully qualified class name of the controller"
                        id="resource"
                        name="resource"
                        :error="$errors->first('resource')"
                    >
                        <x-input.text x-model="resource" :value="old('resource')" data-cy="resource" />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('admin.pages.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
