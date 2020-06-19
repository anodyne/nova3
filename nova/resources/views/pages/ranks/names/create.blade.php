@extends($__novaTemplate)

@section('content')
    <x-page-header title="Add Rank Name">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.names.index') }}">Rank Names</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('ranks.names.store')">
            <x-form.section title="Rank Name Info" message="A rank group is a collection of ranks that can be assigned to characters. We group ranks to make it easier to find the ranks that you need.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Add Rank Name</button>

                <a href="{{ route('ranks.names.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
