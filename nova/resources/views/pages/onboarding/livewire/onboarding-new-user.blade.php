<x-panel variant="well" orientation="horizontal">
    <x-spacing size="md" class="max-w-xs">
        <ul class="text-sm/6">
            @foreach ($process->steps() as $step)
                <li>{{ $step->label() }}</li>
            @endforeach
        </ul>
    </x-spacing>

    <x-panel>
        <x-spacing size="md" class="space-y-8">
            <x-h2>Setup your primary character</x-h2>

            <div class="space-y-4">
                <x-text>
                    Make sure that you have an active character assigned to your account and that the character is
                    marked as a primary character.
                </x-text>
                <x-text>Depending on your permissions, you may need help from the Game Master to do this.</x-text>
            </div>

            <div>
                <x-button :href="route('admin.characters.index', ['only_my_characters' => true])">
                    Manage my characters
                    <div aria-hidden="true">&rarr;</div>
                </x-button>
            </div>
        </x-spacing>
    </x-panel>
</x-panel>
