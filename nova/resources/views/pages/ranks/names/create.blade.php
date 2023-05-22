@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Add a new rank name">
            <x-slot:actions>
                @can('viewAny', Nova\Ranks\Models\RankName::class)
                    <x-button.text :href="route('ranks.names.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan
            </x-slot:actions>
        </x-panel.header>

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
                <x-button.filled type="submit" color="primary">Add</x-button.filled>
                <x-button.outline :href="route('ranks.names.index')" color="gray">Cancel</x-button.outline>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
