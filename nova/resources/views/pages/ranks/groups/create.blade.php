@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Add a new rank group">
            <x-slot name="actions">
                @can('viewAny', Nova\Ranks\Models\RankGroup::class)
                    <x-button.text :href="route('ranks.groups.index')" leading="arrow-left" color="gray">
                        Back
                    </x-button.text>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('ranks.groups.store')">
            <x-form.section
                title="Rank group info"
                message="A rank group is a collection of ranks that can be assigned to characters. We group ranks to make it easier to find the ranks that you need."
            >
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name')" data-cy="name" />
                </x-input.group>

                <x-input.group>
                    <x-switch-toggle
                        name="status"
                        :value="old('status', 'active')"
                        on-value="active"
                        off-value="inactive"
                    >
                        Active
                    </x-switch-toggle>
                </x-input.group>
            </x-form.section>

            <x-form.footer>
                <x-button.filled type="submit" color="primary">Add</x-button.filled>
                <x-button.filled :href="route('ranks.groups.index')" color="gray">Cancel</x-button.filled>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
