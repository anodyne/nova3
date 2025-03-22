@use('Nova\Users\Models\Ban')

<x-admin-layout>
    <x-spacing constrained>
        <x-page-header>
            @can('viewAny', Ban::class)
                <x-slot name="actions">
                    <x-button :href="route('admin.bans.index')" plain>&larr; Back</x-button>
                </x-slot>
            @endcan
        </x-page-header>

        <x-form :action="route('admin.bans.store')">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <flux:radio-group></flux:radio-group>
                    
                    <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                        <x-input.text :value="old('name')" data-cy="name" />
                    </x-fieldset.field>

                    <x-fieldset.field label="Description" id="description" name="description">
                        <x-input.textarea rows="5">
                            {{ old('description') }}
                        </x-input.textarea>
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

                    <x-fieldset.field
                        label="Tags"
                        description="A comma-separated list of tags that can be used for organizing your manifest(s)"
                        id="tags"
                        name="tags"
                    >
                        <x-input.textarea rows="2">
                            {{ old('tags') }}
                        </x-input.textarea>
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('admin.bans.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
</x-admin-layout>
