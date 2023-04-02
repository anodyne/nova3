@extends($meta->template)

@section('content')
    <x-panel>
        <x-panel.header :title="$item->name->name">
            <x-slot:actions>
                @can('viewAny', Nova\Ranks\Models\RankItem::class)
                    <x-link :href="route('ranks.items.index')" leading="arrow-left" size="none" color="gray-text">
                        Back
                    </x-link>
                @endcan

                @can('update', $item)
                    <x-link :href="route('ranks.items.edit', $item)" color="primary" leading="edit">Edit</x-link>
                @endcan
            </x-slot:actions>
        </x-panel.header>

        <x-form action="">
            <x-form.section title="Rank Info" message="You can build up your rank with a few clicks. Assign it to a group, set a name, and pick your base and overlay images to build your rank quickly and easily.">
                <x-input.group label="Rank Name">
                    <p class="font-semibold">{{ $item->name->name }}</p>
                </x-input.group>

                <x-input.group label="Rank Group">
                    <p class="font-semibold">{{ $item->group->name }}</p>
                </x-input.group>

                <x-input.group label="Status">
                    <x-badge :color="$item->status->color()">{{ $item->status->displayName() }}</x-badge>
                </x-input.group>

                <x-input.group label="Preview">
                    <x-rank :rank="$item" />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Characters" message="The following characters have this rank assigned to them.">
                <div class="flex flex-col w-full space-y-2">
                    @foreach ($item->characters as $character)
                        <div class="group flex items-center justify-between w-full py-2 px-4 rounded odd:bg-gray-100 dark:odd:bg-gray-700/50">
                            <div class="flex items-center">
                                <x-avatar.character
                                    :character="$character"
                                    :primary-status="true"
                                    :primary-rank="false"
                                    :secondary-positions="false"
                                    :secondary-type="true"
                                ></x-avatar.character>
                            </div>

                            @can('update', $character)
                                <x-link :href="route('characters.edit', $character)" color="gray-text" size="none" class="group-hover:visible sm:invisible">
                                    @icon('edit')
                                </x-link>
                            @endcan
                        </div>
                    @endforeach
                </div>
            </x-form.section>

            <x-form.footer>
                <x-link :href="route('ranks.items.index')" color="white">Back</x-link>
            </x-form.footer>
        </x-form>
    </x-panel>
@endsection
