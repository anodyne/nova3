<div class="grid grid-cols-3 gap-x-8">
    <aside>
        <x-page-header>
            <x-slot name="heading">Messages</x-slot>

            <x-slot name="actions">
                <x-dropdown placement="bottom-end">
                    <x-slot name="trigger">
                        <x-icon name="write" size="sm"></x-icon>
                    </x-slot>

                    <x-dropdown.group>
                        @foreach ($users as $user)
                            <x-dropdown.item type="button" wire:click="startNewConversation({{ $user->id }})">
                                {{ $user->name }}
                            </x-dropdown.item>
                        @endforeach
                    </x-dropdown.group>
                </x-dropdown>
            </x-slot>
        </x-page-header>

        <ul role="list" x-auto-animate.175ms>
            @forelse ($conversations as $conversation)
                @php($participant = $conversation->participants->first())

                <li
                    @class([
                        'flex cursor-pointer items-center gap-x-4 rounded-xl px-2.5 py-4',
                        'bg-primary-100 ring-1 ring-inset ring-primary-950/10 dark:bg-primary-950 dark:ring-white/10' => $selected === $conversation->id,
                    ])
                    wire:click="selectConversation({{ $conversation->id }})"
                >
                    @if (filled($participant))
                        <x-avatar :src="$participant->avatar_url" :tooltip="$participant->name" size="sm"></x-avatar>
                    @else
                        <x-icon name="user" size="xl"></x-icon>
                    @endif

                    <div class="flex min-w-0 items-center">
                        @if (filled($participant))
                            <x-h4>{{ $participant?->name }}</x-h4>
                            {{-- <p class="mt-1 truncate text-xs/5 text-gray-500">leslie.alexander@example.com</p> --}}
                        @else
                            <x-text size="lg">New message</x-text>
                        @endif
                    </div>
                </li>
            @empty
                <li>
                    <x-empty-state>
                        <x-icon name="messages"></x-icon>
                        <x-h3>No conversations</x-h3>
                        <x-text>Get started by creating a new conversation</x-text>

                        <x-button wire:click="startNewConversation" color="primary">
                            <x-icon name="write" size="sm"></x-icon>
                            Start a new conversation
                        </x-button>
                    </x-empty-state>
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
