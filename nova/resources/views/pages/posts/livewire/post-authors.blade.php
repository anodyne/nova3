<div class="space-y-4">
    @if ($hasAuthors)
        <ul>
            @foreach ($characterAuthors as $characterAuthor)
                <li class="rounded-lg px-3 py-1 odd:bg-gray-100 dark:odd:bg-gray-900">
                    <div class="text-sm/6 font-medium text-gray-950 dark:text-white">
                        {{ $characterAuthor->name }}
                    </div>

                    @if (filled($characterAuthor->pivot->user_id))
                        <div class="text-xs/5">
                            played by
                            {{ $characterAuthor->pivot?->user?->name ?? 'Unassigned' }}
                        </div>
                    @endif
                </li>
            @endforeach

            @foreach ($userAuthors as $userAuthor)
                <li class="rounded-lg px-3 py-1 odd:bg-gray-100 dark:odd:bg-gray-900">
                    <div class="text-sm/6 font-medium text-gray-950 dark:text-white">
                        {{ filled($userAuthor->pivot?->as) ? $userAuthor->pivot->as : 'Additional character' }}
                    </div>
                    <div class="text-xs/5">played by {{ $userAuthor->name }}</div>
                </li>
            @endforeach
        </ul>

        <x-button wire:click="openForEditing" variant="ghost">
            Manage authors
            <span aria-hidden="true">→</span>
        </x-button>
    @else
        <a role="button" wire:click="openForEditing" class="group">
            <x-empty variant="compact">
                <x-icon :name="Tabler::MasksTheater" />
                <x-empty.heading>No authors</x-empty.heading>
                <x-empty.text>
                    There are no authors for your post. Add an author to continue writing your post.
                </x-empty.text>
            </x-empty>
        </a>
    @endif
</div>
