@extends($meta->template)

@section('content')
    <x-page-header :title="$item->name->name">
        <x-slot:pretitle>
            <a href="{{ route('ranks.items.index') }}">Rank Items</a>
        </x-slot:pretitle>

        <x-slot:controls>
            @can('update', $item)
                <x-link :href="route('ranks.items.edit', $item)" color="blue">Edit Rank Item</x-link>
            @endcan
        </x-slot:controls>
    </x-page-header>

    <x-panel>
        <x-form action="">
            <x-form.section title="Rank Info" message="You can build up your rank with a few clicks. Assign it to a group, set a name, and pick your base and overlay images to build your rank quickly and easily.">
                <x-input.group label="Rank Name">
                    <p class="font-semibold">{{ $item->name->name }}</p>
                </x-input.group>

                <x-input.group label="Rank Group">
                    <p class="font-semibold">{{ $item->group->name }}</p>
                </x-input.group>

                <x-input.group label="Preview">
                    <x-rank :rank="$item" />
                </x-input.group>
            </x-form.section>

            <x-form.section title="Characters" message="The following characters have this rank assigned to them.">
                <div class="flex flex-col w-full space-y-2">
                    @foreach ($item->characters as $character)
                        <div class="group flex items-center justify-between w-full py-2 px-4 rounded odd:bg-gray-3">
                            <div class="flex items-center">
                                <x-avatar-meta size="lg" :src="$character->avatar_url">
                                    <x-slot:primaryMeta>
                                        <x-status :status="$character->status" />
                                        <span class="ml-2">{{ $character->name }}</span>
                                    </x-slot:primaryMeta>

                                    <x-slot:secondaryMeta>
                                        <x-badge :color="$character->type->color()" size="xs">{{ $character->type->displayName() }}</x-badge>
                                    </x-slot:secondaryMeta>
                                </x-avatar-meta>
                            </div>

                            @can('update', $character)
                                <a href="{{ route('characters.edit', $character) }}" class="text-gray-11 transition ease-in-out duration-200 hover:text-gray-12 group-hover:visible sm:invisible">
                                    @icon('edit')
                                </a>
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
