@props([
    'user',
    'secondaryStatus' => false,
    'secondaryType' => false,
])

<x-avatar.meta
    :src="$user->avatar_url"
    :primary="$user->name"
    {{ $attributes }}
>
    @if ($secondaryStatus || $secondaryType)
        <x-slot:secondary>
            @if ($secondaryStatus)
                <x-badge :color="$user->status->color()" size="xs">{{ $user->status->displayName() }}</x-badge>
            @endif

            @if ($secondaryType)
                <x-badge :color="$user->type->color()" size="xs">{{ $user->type->displayName() }}</x-badge>
            @endif
        </x-slot:secondary>
    @endif
</x-avatar.meta>
