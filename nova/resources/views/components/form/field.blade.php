@aware(['admin' => false])

<div>
    @if ($admin)
        <x-input.text placeholder="Placeholder"></x-input.text>
    @else
        <x-public::field.text placeholder="Placeholder"></x-public::field.text>
    @endif
</div>
