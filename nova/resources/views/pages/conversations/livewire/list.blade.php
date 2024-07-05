<div class="grid grid-cols-3 gap-x-8">
    <aside>
        <x-page-header>
            <x-slot name="heading">Messages</x-slot>

            <x-slot name="actions">
                <x-button color="neutral" wire:click="newConversation">
                    <x-icon name="write" size="sm"></x-icon>
                </x-button>
            </x-slot>
        </x-page-header>

        <ul role="list" x-auto-animate.175ms>
            @forelse ($conversations as $conversation)
                @php($recipient = $conversation->recipients->first())

                <li
                    @class([
                        'flex cursor-pointer items-center gap-x-4 rounded-xl px-2.5 py-4',
                        'bg-primary-100 ring-1 ring-inset ring-primary-950/10 dark:bg-primary-950 dark:ring-white/10' => $selected === $conversation->id,
                    ])
                    wire:click="selectConversation({{ $conversation->id }})"
                >
                    @if (filled($recipient))
                        <x-avatar :src="$recipient->avatar_url" :tooltip="$recipient->name" size="sm"></x-avatar>
                    @else
                        <x-icon name="tabler-user-plus" size="xl"></x-icon>
                    @endif

                    <div class="flex min-w-0 items-center">
                        @if (filled($recipient))
                            <x-h4>
                                {{ $recipient?->name }}
                            </x-h4>
                            {{-- <p class="mt-1 truncate text-xs/5 text-gray-500">leslie.alexander@example.com</p> --}}
                        @else
                            <x-input.text placeholder="Pick a user"></x-input.text>
                        @endif
                    </div>
                </li>
            @empty
                <li class="py-6">
                    <div class="text-center">
                        <x-icon name="messages" size="2xl" class="mx-auto text-gray-400"></x-icon>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900">No conversations</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new conversation.</p>
                        <div class="mt-6">
                            <x-button type="button" color="primary" wire:click="newConversation">
                                <x-icon name="add" size="sm"></x-icon>
                                Start a new conversation
                            </x-button>
                        </div>
                    </div>
                </li>
            @endforelse
        </ul>
    </aside>

    <section class="col-span-2">
        <livewire:conversations-messages :conversation-id="$selected" />
    </section>
</div>

@pushOnce('scripts')
<script
    src="https://cdn.jsdelivr.net/npm/@marcreichel/alpine-auto-animate@latest/dist/alpine-auto-animate.min.js"
    defer
></script>
@endPushOnce
