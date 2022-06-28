@extends($meta->template)

@section('content')
    <x-page-header title="Add Rank Name">
        <x-slot:pretitle>
            <a href="{{ route('ranks.names.index') }}">Rank Names</a>
        </x-slot:pretitle>
    </x-page-header>

    <x-panel>
        <x-form :action="route('ranks.names.store')">
            <x-form.section title="Rank Name Info" message="Rank names allow you to re-use basic rank information across all of your ranks to avoid unnecessary and tedious editing of the same information across every rank in the system.">
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group>
                    <x-input.toggle
                        field="status"
                        :value="old('status', 'active')"
                        active-value="active"
                        inactive-value="inactive"
                    >
                        Active
                    </x-input.toggle>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Add Rank Name</x-button>
                <x-link :href="route('ranks.names.index')" color="white">Cancel</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
