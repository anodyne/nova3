@props([
    'user',
    'secondaryStatus' => false,
    'secondaryPronouns' => false,
])

<x-avatar.meta :src="$user->avatar_url" :primary="$user->name" {{ $attributes }}>
    @if ($secondaryStatus || $secondaryPronouns)
        <x-slot name="secondary">
            @if ($secondaryStatus)
                <x-badge :color="$user->status->color()">{{ $user->status->getLabel() }}</x-badge>
            @endif

            @if ($secondaryPronouns)
                <div class="flex items-center space-x-1 text-xs text-gray-500 dark:text-gray-400">
                    {{ $user->pronouns }}
                </div>
            @endif
        </x-slot>
    @endif
</x-avatar.meta>
