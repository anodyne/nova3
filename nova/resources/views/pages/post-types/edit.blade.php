@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$postType->name">
        <x-slot name="pretitle">
            <a href="{{ route('post-types.index') }}">Post Types</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('post-types.update', $postType)">
            <x-form.section title="Post Type Info" message="A role is a collection of permissions that allows a user to take certain actions throughout Nova. Since a user can have as many roles as you'd like, we recommend creating roles with fewer permissions to give yourself more freedom to add and remove access for a given user.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $postType->name)" data-cy="name" />
                </x-input.group>

                <x-input.group label="Key" for="key" :error="$errors->first('key')">
                    <x-input.text id="key" name="key" :value="old('key', $postType->key)" data-cy="key" />
                </x-input.group>

                <x-input.group label="Description" for="description">
                    <x-input.textarea id="description" name="description" data-cy="description" rows="3">{{ old('description', $postType->description) }}</x-input.textarea>
                </x-input.group>

                <x-input.group label="Visibility" for="visibility" :error="$errors->first('visibility')">
                    <x-input.radio
                        label="In character"
                        for="in_character"
                        name="visibility"
                        id="in_character"
                        value="in-character"
                        :checked="old('visibility', $user->visibility) === 'in-character'"
                        data-cy="visibility"
                    />

                    <span class="ml-6">
                        <x-input.radio
                            label="Out of character"
                            for="out_of_character"
                            name="visibility"
                            id="out_of_character"
                            value="out-of-character"
                            :checked="old('visibility', $user->visibility) === 'out-of-character'"
                            data-cy="visibility"
                        />
                    </span>
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

            <x-form.section title="Notifications" message="You can set notifications on a post type basis. Select here whether you'd like this post type to send out notifications to members of the game. (Subject to per-user notification settings.)">
                <x-input.group>
                    <x-input.toggle
                        field="active"
                        :value="old('active', $theme->active ?? '')"
                        active-text="Notify users"
                        inactive-text="Do not notify users"
                    />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Roles">
                <x-slot name="message">
                    <p>You can set access control around posting certain types of posts.</p>

                    @can('viewAny', 'Nova\Roles\Models\Role')
                        <a href="{{ route('roles.index') }}" class="button button-soft button-sm mt-6">
                            Manage roles
                        </a>
                    @endcan
                </x-slot>

                <x-input.group label="Assign roles">
                    @livewire('roles:manage-roles', ['roles' => []])
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Update Post Type</button>

                <a href="{{ route('post-types.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
