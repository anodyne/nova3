@props([
    'currentState' => false,
    'states',
])

<select {{ $attributes->merge(['class' => 'form-select w-full | sm:w-1/2']) }}>
    <option value="{{ $currentState }}" selected>{{ $currentState->displayName() }}</option>
    @foreach ($states as $state)
        <option value="{{ $state }}">{{ get_class_name($state) }}</option>
    @endforeach
</select>