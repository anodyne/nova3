@extends($__novaTemplate)

@section('content')
    <x-page-header :title="$item->name->name">
        <x-slot name="pretitle">
            <a href="{{ route('ranks.items.index') }}">Rank Items</a>
        </x-slot>

        <x-slot name="controls">
            @can('update', $item)
                <a href="{{ route('ranks.items.edit', $item) }}" class="button button-primary">Edit Rank Item</a>
            @endcan
        </x-slot>
    </x-page-header>

    <x-panel>
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
                    <div class="group flex items-center justify-between w-full py-2 px-4 rounded odd:bg-gray-100">
                        <div class="flex items-center">
                            <x-avatar-meta size="lg" :src="$character->avatar_url">
                                <x-slot name="primaryMeta">
                                    <x-status :status="$character->status" />
                                    <span class="ml-2">{{ $character->name }}</span>
                                </x-slot>

                                <x-slot name="secondaryMeta">
                                    <x-badge :type="$character->type->color()" size="sm">{{ $character->type->displayName() }}</x-badge>
                                </x-slot>
                            </x-avatar-meta>
                        </div>

                        @can('update', $character)
                            <a href="{{ route('characters.edit', $character) }}" class="text-gray-500 transition ease-in-out duration-150 hover:text-gray-700 group-hover:visible | sm:invisible">
                                @icon('edit')
                            </a>
                        @endcan
                    </div>
                @endforeach
            </div>
        </x-form.section>

        <x-form.footer>
            <a href="{{ route('ranks.items.index') }}" class="button">Back</a>
        </x-form.footer>
    </x-panel>
@endsection
