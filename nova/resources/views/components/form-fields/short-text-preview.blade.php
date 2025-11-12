@php
    $details = $data['details'] ?? [];
    $attrs = $data['attrs'] ?? [];
@endphp

<x-public::field.preview>
    <x-form-fields.short-text :$details :$attrs />
</x-public::field.preview>
