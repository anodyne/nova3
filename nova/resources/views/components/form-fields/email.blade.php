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

            <x-input.email
                :id="$uid"
                :name="$inputName"
                :attributes="$attributesBag"
                wire:model.live.debounce="values.{{ $uid }}"
            />

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
        <x-public::field.email
            :label="$label"
            :description="$description"
            :attributes="$attributesBag"
            wire:model.live.debounce="values.{{ $uid }}"
        />
    @endif
@endif
