@aware([
    'admin' => false,
    'form' => null,
    'static' => false,
    'values' => [],
])

@use('Illuminate\View\ComponentAttributeBag')
@use('Nova\Forms\Enums\FormType')

@php
    $attrs = array_merge(
        $attrs,
        $attrs['other'] ?? []
    );

    $options = collect(data_get($attrs, 'options') ?? []);

    // If we received `[ ['key'=>'..','value'=>'..'], ... ]`, convert to assoc
    if ($options->first() && is_array($options->first()) && array_key_exists('key', $options->first())) {
        $options = $options->mapWithKeys(fn ($item) => [$item['key'] => $item['value']]);
    }

    // If we ever get a simple list like ['Male','Female'], make it key=>value
    if (function_exists('array_is_list') && array_is_list($options->all())) {
        $options = $options->mapWithKeys(fn ($v) => [$v => $v]);
    }

    $options = $options->all();

    unset($attrs['options']);
    unset($attrs['other']);

    $form ??= $this->getNovaForm();

    $uid = data_get($attrs, 'id');
    $label = data_get($details, 'label');
    $description = data_get($details, 'description');

    $hideWhenEmpty = data_get($details, 'hideWhenEmpty');
    $required = data_get($details, 'required');

    $inputName = $form ? $form?->key."[{$uid}]" : data_get($attrs, 'name');

    $attrs['name'] = $inputName;

    $attributesBag = new ComponentAttributeBag((array) $attrs);

    $errorKey = $form->type === FormType::Basic ? "values.{$uid}" : "{$form->key}.{$uid}";
    $error = $errors->getBag('default')->first($errorKey);

    $value = data_get($values, $uid);
@endphp

@if ($admin)
    @if ($static)
        @if (filled($value) || blank($value) && ! $hideWhenEmpty)
            <x-input.display :label="$label" :id="$uid">
                <x-text>
                    {{ filled($value) ? $value : '—' }}
                </x-text>
            </x-input.display>
        @endif
    @else
        <x-field>
            @if (filled($label))
                <x-label>{{ $label }}</x-label>
            @endif

            @if (filled($description))
                <x-description>{{ $description }}</x-description>
            @endif

            <x-select
                :id="$uid"
                :name="$inputName"
                :attributes="$attributesBag"
                wire:model.live.debounce="values.{{ $uid }}"
            >
                @if ($attributesBag->has('placeholder'))
                    <option value="">{{ $attributesBag->get('placeholder') }}</option>
                @endif

                @foreach ((array) $options as $key => $value)
                    <option value="{{ $key }}">
                        {{ $value }}
                    </option>
                @endforeach
            </x-select>

            <x-field.error :name="$errorKey" />
        </x-field>
    @endif
@else
    @if ($static)
        @if (filled($value) || blank($value) && ! $hideWhenEmpty)
            <x-public::field :label="$label">
                <div data-slot="text">
                    {{ filled($value) ? $value : '—' }}
                </div>
            </x-public::field>
        @endif
    @else
        <x-public::field.select
            :label="$label"
            :description="$description"
            :attributes="$attributesBag"
            wire:model.live.debounce="values.{{ $uid }}"
        >
            @if ($attributesBag->has('placeholder'))
                <option value="">{{ $attributesBag->get('placeholder') }}</option>
            @endif

            @foreach ((array) $options as $key => $value)
                <option value="{{ $key }}">
                    {{ $value }}
                </option>
            @endforeach
        </x-public::field.select>
    @endif
@endif
