@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Post Type">
        <x-slot name="pretitle">
            <a href="{{ route('post-types.index') }}">Post Types</a>
        </x-slot>
    </x-page-header>

    <x-panel
        x-data="{ name: '{{ old('name') }}', key: '{{ old('key') }}', suggestKey: true }"
        x-init="
            $watch('name', value => {
                if (suggestKey) {
                    key = value.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
                }
            })
        "
    >
        <x-form :action="route('post-types.store')">
            <x-form.section title="Post Type Info" message="A role is a collection of permissions that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer permissions to give yourself more freedom to add and remove access for a given user.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text x-model="name" id="name" name="name" data-cy="name" />
                </x-input.group>

                <x-input.group label="Key" for="key" :error="$errors->first('key')">
                    <x-input.text x-model="key" x-on:change="suggestKey = false" id="key" name="key" data-cy="key" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="3">{{ old('description') }}</x-input.textarea>
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
                        field="active"
                        :value="old('active', true)"
                        active-text="Active"
                        inactive-text="Inactive"
                    />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Fields" message="Post types determine which fields are available when creating a post of that type.">
                <x-input.group>
                    <x-input.toggle
                        field="active"
                        :value="old('active', $theme->active ?? '')"
                        active-text="Show title field"
                        inactive-text="Hide title field"
                    />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="active"
                        :value="old('active', $theme->active ?? '')"
                        active-text="Show time field"
                        inactive-text="Hide time field"
                    />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="active"
                        :value="old('active', $theme->active ?? '')"
                        active-text="Show location field"
                        inactive-text="Hide location field"
                    />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="active"
                        :value="old('active', $theme->active ?? '')"
                        active-text="Show content field"
                        inactive-text="Hide content field"
                    />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Options">
                <x-input.group>
                    <x-input.toggle
                        field="active"
                        :value="old('active', $theme->active ?? '')"
                        active-text="Notify users"
                        inactive-text="Do not notify users"
                    />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="active"
                        :value="old('active', $theme->active ?? '')"
                        active-text="Include in post counts"
                        inactive-text="Exclude from post counts"
                    />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="active"
                        :value="old('active', $theme->active ?? '')"
                        active-text="Allow multiple authors"
                        inactive-text="Do not allow multiple authors"
                    />
                </x-input.group>

                <x-input.group label="Restrict posting" help="You can set a specific role a user must have in order to use certain post types.">
                    <select name="roles" id="roles" class="form-select w-full | md:w-2/3">
                        <option value="">No role restrictions</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Add Post Type</button>

                <a href="{{ route('post-types.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
