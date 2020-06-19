@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$name->name">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.names.index') }}">Rank Names</a>
        </x-slot>
    </x-page-header>

    <x-panel>
        <x-form :action="route('ranks.names.update', $name)" method="PUT">
            <x-form.section title="Rank Name Info" message="Rank names allow you to re-use basic rank information across all of your ranks to avoid unnecessary and tedious editing of the same information across every rank in the system.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $name->name)" data-cy="name" />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Assigned Ranks" message="These are the ranks that have been assigned this name.">
                Coming soon...
            </x-form.section>

            <x-form.footer>
                <button type="submit" class="button button-primary">Update Rank Name</button>

                <a href="{{ route('ranks.names.index') }}" class="button">Cancel</a>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
