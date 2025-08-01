@aware([
    'admin' => false,
    'form' => null,
    'static' => false,
    'values' => [],
])

@use('Illuminate\View\ComponentAttributeBag')
@use('Nova\Forms\Enums\FormType')

@php
    $form ??= $this->getNovaForm();

    $uid = data_get($attrs, 'id');
    $label = data_get($details, 'label');
    $description = data_get($details, 'description');

    $hideWhenEmpty = data_get($details, 'hideWhenEmpty');
    $required = data_get($details, 'required');

    $defaults = collect($attrs['defaults'] ?? [])
        ->map(fn ($value, $key) => ['key' => $key, 'value' => $value])
        ->values();

    unset($attrs['defaults']);

    $inputName = $form ? $form?->key."[{$uid}]" : data_get($attrs, 'name');

    $attrs['name'] = $inputName;

    $attributesBag = new ComponentAttributeBag((array) $attrs);

    $errorKey = $form->type === FormType::Basic ? "values.{$uid}" : "{$form->key}.{$uid}";
    $error = $errors->getBag('default')->first($errorKey);

    $value = data_get($values, $uid);
    $value = json_decode($value);
@endphp

@if ($admin)
    @if ($static)
        @if (filled($value) || blank($value) && ! $hideWhenEmpty)
            <x-fieldset.field :label="$label" :id="$uid">
                @if (filled($value))
                    <div class="not-prose" data-slot="control">
                        <dl>
                            @foreach ($value as $item)
                                <div
                                    class="rounded-lg px-4 py-2 odd:bg-gray-950/[.04] sm:grid sm:grid-cols-3 sm:gap-4 dark:odd:bg-white/[.07]"
                                >
                                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">
                                        {{ data_get($item, 'key') }}
                                    </dt>
                                    <dd class="mt-1 text-sm/6 text-gray-600 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                        {{ data_get($item, 'value') }}
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @else
                    <x-text>—</x-text>
                @endif
            </x-fieldset.field>
        @endif
    @else
        <x-fieldset.field
            :label="$label"
            :description="$description"
            :id="$uid"
            :name="$inputName"
            :error="$error"
            :required="$required"
        >
            <x-input.key-value
                :attributes="$attributesBag"
                :$defaults
                :$value
                wire:model.live.debounce="values.{{ $uid }}"
            ></x-input.key-value>
        </x-fieldset.field>
    @endif
@else
    @if ($static)
        @if (filled($value) || blank($value) && ! $hideWhenEmpty)
            <x-public::field :$label>
                <div class="not-prose" data-slot="control">
                    @if (filled($value))
                        <dl>
                            @foreach ($value as $item)
                                <div
                                    class="rounded-lg px-4 py-2 odd:bg-gray-950/[.04] sm:grid sm:grid-cols-3 sm:gap-4 dark:odd:bg-white/[.07]"
                                >
                                    <dt class="text-sm/6 font-medium text-gray-900 dark:text-white">
                                        {{ data_get($item, 'key') }}
                                    </dt>
                                    <dd class="mt-1 text-sm/6 text-gray-600 sm:col-span-2 sm:mt-0 dark:text-gray-400">
                                        {{ data_get($item, 'value') }}
                                    </dd>
                                </div>
                            @endforeach
                        </dl>
                    @else
                        —
                    @endif
                </div>
            </x-public::field>
        @endif
    @else
        <x-public::field.key-value
            :label="$label"
            :description="$description"
            :required="$required"
            :attributes="$attributesBag"
            :$defaults
            :$value
            wire:model.live.debounce="values.{{ $uid }}"
        ></x-public::field.key-value>
    @endif
@endif
