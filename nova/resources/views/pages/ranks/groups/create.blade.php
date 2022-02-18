@extends($meta->template)

@section('content')
    <x-page-header title="Add Rank Group">
        <x-slot:pretitle>
            <a href="{{ route('ranks.groups.index') }}">Rank Groups</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-panel>
        <x-form :action="route('ranks.groups.store')">
            <x-form.section title="Rank Group Info" message="A rank group is a collection of ranks that can be assigned to characters. We group ranks to make it easier to find the ranks that you need.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="blue">Add Rank Group</x-button>
                <x-link :href="route('ranks.groups.index')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
