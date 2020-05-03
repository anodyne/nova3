@props(['clean', 'fieldId', 'help', 'label'])

<div {{ $attributes->merge(['class' => 'field-wrapper']) }}>
    <label class="field-label" for="{{ $fieldId }}">
        {{ $label }}
    </label>

    @if (isset($clean))
        {{ $clean }}
    @else
        <div class="field-group">
            @if (isset($addonBefore))
                <div class="field-addon">
                    {{ $addonBefore }}
                </div>
            @endif

            {{ $slot }}

            @if (isset($addonAfter))
                <div class="field-addon">
                    {{ $addonAfter }}
                </div>
            @endif
        </div>

        @if ($errors->has($fieldId))
            <div class="field-error" role="alert">
                <icon name="alert-circle"></icon>
                {{ $errors->first($fieldId) }}
            </div>
        @endif

        @if (isset($help))
            <div class="field-help" role="note">
                {{ $help }}
            </div>
        @endif
    @endif
</div>