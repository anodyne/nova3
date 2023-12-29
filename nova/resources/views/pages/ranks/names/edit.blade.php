@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header title="Edit rank name">
            <x-slot name="actions">
                @can('viewAny', Nova\Ranks\Models\RankName::class)
                    <x-button :href="route('ranks.names.index')" color="neutral" plain>&larr; Back</x-button>
                @endcan
            </x-slot>
        </x-panel.header>

        <x-form :action="route('ranks.names.update', $name)" method="PUT">
            <x-form.section
                title="Rank name info"
                message="Rank names allow you to re-use basic rank information across all of your ranks to avoid unnecessary and tedious editing of the same information across every rank in the system."
            >
                <x-input.group label="Name" for="name" :error="$errors->first('name')">
                    <x-input.text id="name" name="name" :value="old('name', $name->name)" data-cy="name" />
                </x-input.group>

                <div class="flex items-center gap-x-2.5">
                    <x-switch
                        name="status"
                        :value="old('status', $name->status->value ?? 'active')"
                        on-value="active"
                        off-value="inactive"
                        id="status"
                    ></x-switch>
                    <x-fieldset.label for="status">Active</x-fieldset.label>
                </div>
            </x-form.section>

            <x-form.section
                title="Assigned Ranks"
                message="These are the rank items that have been assigned this rank name."
            >
                <div class="flex w-full flex-col">
                    @foreach ($name->ranks as $rank)
                        <div
                            class="group flex items-center justify-between rounded-md px-4 py-2 odd:bg-gray-100 dark:odd:bg-gray-700/50"
                        >
                            <div class="flex flex-col sm:flex-row sm:items-center">
                                <div class="flex items-center gap-2">
                                    <x-status :status="$rank->status"></x-status>
                                    <x-rank :rank="$rank" />
                                </div>
                                <span class="ml-3 font-medium text-gray-600 dark:text-gray-300">
                                    {{ $rank->group?->name }}
                                </span>
                            </div>

                            @can('update', $rank)
                                <x-button
                                    :href="route('ranks.items.edit', $rank)"
                                    color="neutral"
                                    class="group-hover:visible sm:invisible"
                                    text
                                >
                                    <x-icon name="edit" size="sm"></x-icon>
                                </x-button>
                            @endcan
                        </div>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.footer>
                <x-button type="submit" color="primary">Update</x-button>
                <x-button :href="route('ranks.names.index')" plain>Cancel</x-button>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
