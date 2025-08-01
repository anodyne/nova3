@props([
    'label' => null,
    'description' => null,
    'id' => null,
    'error' => null,
    'required' => null,
])

@aware(['form' => null])

@php
    if (filled($form)) {
        $id = data_get($attributes, 'id');

        $errorKey = "{$form->key}.{$id}";
        $error = $errors->getBag('default')->first($errorKey);
    }
@endphp

<x-public::field :$label :$description :$error :$required>
    <fieldset class="mt-4">
        <div class="space-y-4">
            {{ $slot }}
        </div>
    </fieldset>
</x-public::field>
