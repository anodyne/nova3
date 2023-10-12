<div
    wire:ignore.self
    x-data="switchToggle({
        @if ($hasWireModel())
            value: @entangle($attributes->wire('model')),
        @elseif ($hasXModel())
            value: {{ $attributes->first('x-model') }},
        @else
            value: {{ \Illuminate\Support\Js::from($value) }},
        @endif
        onValue: {{ \Illuminate\Support\Js::from($onValue) }},
        offValue: {{ \Illuminate\Support\Js::from($offValue) }},
    })"
    @if ($hasXModel())
        x-modelable="value"
        {{ $attributes->whereStartsWith('x-model') }}
    @endif
    class="flex items-center"
>
    <label class="{{ $containerClass() }}">
        <input type="hidden" value="{{ $offValue }}" @if ($name) name="{{ $name }}" @endif />
        <input type="checkbox" @if ($onValue && ! is_bool($onValue))
                 value="{{ $onValue }}"
             @endif @class([
            'sr-only peer',
            'input-error' => $hasErrorsAndShow($name),
        ]) x-bind:checked="isPressed" x-on:change="toggle" {{ $attributes->except(['type', 'x-model', 'wire:model', 'wire:model.live', 'wire:model.blur', 'aria-describedby', 'class']) }} @if ($name) name="{{ $name }}" @endif @if ($id) id="{{ $id }}" @endif @if ($disabled) disabled @endif @if ($hasErrorsAndShow($name))
                 aria-invalid="true"
             @endif {!! $ariaDescribedBy() !!} />

        @if ($labelLeft)
            <span class="switch-toggle__label--left switch-toggle__label">{{ $labelLeft }}</span>
        @endif

        <div class="{{ $switchClass() }}">
            @if ($offIcon && ! $short)
                <span {{ $componentSlot($offIcon)->attributes->class('switch-toggle__icon switch-toggle__icon--off') }}>
                    @if (is_string($offIcon))
                        <x-dynamic-component :component="$offIcon" />
                    @else
                        {{ $offIcon }}
                    @endif
                </span>
            @endif

            @if ($onIcon && ! $short)
                <span {{ $componentSlot($onIcon)->attributes->class('switch-toggle__icon switch-toggle__icon--on') }}>
                    @if (is_string($onIcon))
                        <x-dynamic-component :component="$onIcon" />
                    @else
                        {{ $onIcon }}
                    @endif
                </span>
            @endif
        </div>

        @if ($label || ! $slot->isEmpty())
            <span class="switch-toggle__label--right switch-toggle__label">{{ $label ?? $slot }}</span>
        @endif
    </label>
</div>
