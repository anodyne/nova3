@extends($meta->template)

@use('Nova\Ranks\Models\RankName')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Add a new rank name</x-slot>

            <x-slot name="actions">
                @can('viewAny', RankName::class)
                    <x-button :href="route('ranks.names.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form :action="route('ranks.names.store')">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="Name" id="name" name="name" :error="$errors->first('name')">
                        <x-input.text :value="old('name')" data-cy="name" />
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
                <x-button :href="route('ranks.names.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
