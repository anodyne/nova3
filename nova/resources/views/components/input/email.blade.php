@props([
    'leadingAddOn' => false,
    'trailingAddOn' => false,
])

<div class="field-group">
    @if ($leadingAddOn)
        <div class="field-addon">
            {{ $leadingAddOn }}
        </div>
    @endif

    <input type="email" class="field" {{ $attributes }}>

    @if ($trailingAddOn)
        <div class="field-addon">
            {{ $trailingAddOn }}
        </div>
    @endif
</div>
