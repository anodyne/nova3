<div class="space-y-4">
    @if ($hasAuthors)
        <ul>
            @foreach ($characterAuthors as $characterAuthor)
                <li class="rounded-lg px-3 py-1 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]">
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
                <li class="rounded-lg px-3 py-1 odd:bg-gray-950/[.04] dark:odd:bg-white/[.07]">
                    <div class="text-sm/6 font-medium text-gray-950 dark:text-white">
                        {{ filled($userAuthor->pivot?->as) ? $userAuthor->pivot->as : 'Additional character' }}
                    </div>
                    <div class="text-xs/5">played by {{ $userAuthor->name }}</div>
                </li>
            @endforeach
        </ul>

        <x-button wire:click="openForEditing" plain>Manage authors &rarr;</x-button>
    @else
        <a role="button" wire:click="openForEditing" class="group">
            <x-empty-state
                variant="compact"
                class="rounded-lg border border-dashed border-gray-950/54 transition group-hover:bg-gray-950/[.02] dark:border-white/10 dark:group-hover:bg-white/[.04]"
            >
                <x-icon :name="Icon::Characters"></x-icon>
                <x-h2>No authors</x-h2>
                <x-text>There are no authors for your post. Add an author to continue writing your post.</x-text>
            </x-empty-state>
        </a>
    @endif
</div>
