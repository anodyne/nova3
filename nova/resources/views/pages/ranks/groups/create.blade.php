@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Add a new rank group">
            <x-slot name="actions">
                @can('viewAny', Nova\Ranks\Models\RankGroup::class)
                    <x-button :href="route('ranks.groups.index')" color="neutral" plain>&larr; Back</x-button>
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
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Add</x-button>
                <x-button :href="route('ranks.groups.index')" plain>Cancel</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
