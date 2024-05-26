@props([
    'label' => null,
    'description' => null,
])

<x-public::field :label="$label" :description="$description">
    <fieldset class="mt-4">
        <div class="space-y-4">
            {{ $slot }}
        </div>
    </fieldset>
</x-public::field>
