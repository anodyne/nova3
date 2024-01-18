@extends($meta->template)

@use('Nova\Pages\Models\Page')

@section('content')
    <x-spacing constrained>
        <x-page-header>
            <x-slot name="heading">Add a new page</x-slot>

            <x-slot name="actions">
                @can('viewAny', Page::class)
                    <x-button :href="route('pages.index')" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-page-header>

        <x-form :action="route('pages.store')">
            <x-fieldset>
                <x-fieldset.field-group constrained>
                    <x-fieldset.field label="URI" id="uri" name="uri" :error="$errors->first('uri')">
                        <x-input.text :value="old('uri')" data-cy="uri" />
                    </x-fieldset.field>
                </x-fieldset.field-group>
            </x-fieldset>

            <x-fieldset.controls>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('pages.index')" plain>Cancel</x-button>
            </x-fieldset.controls>
        </x-form>
    </x-spacing>
@endsection
