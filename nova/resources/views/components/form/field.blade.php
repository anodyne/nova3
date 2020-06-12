<div {{ $attributes->merge(['class' => $errors->has($fieldId) ? 'field-wrapper has-error' : 'field-wrapper']) }}>
    <label class="field-label" for="{{ $fieldId }}">
        {{ $label }}
    </label>

    @if (isset($clean) && $clean)
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

        @error($fieldId)
            <div class="field-error" role="alert">
                @icon('alert')
                {{ $message }}
            </div>
        @enderror

        @if (isset($help))
            <div class="field-help" role="note">
                {{ $help }}
            </div>
        @endif
    @endif
</div>
