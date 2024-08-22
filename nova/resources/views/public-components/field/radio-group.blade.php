@props([
    'label' => null,
    'description' => null,
    'id' => null,
    'error' => null,
])

@aware(['form' => null])

@php
    if (filled($form)) {
        $errorKey = "{$form->key}.{$id}";
        $error = $errors->getBag('default')->first($errorKey);
    }
@endphp

<x-public::field :$label :$description :$error>
    <fieldset class="mt-4">
        <div class="space-y-4">
            {{ $slot }}
        </div>
    </fieldset>
</x-public::field>
