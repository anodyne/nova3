@props([
    'currentState' => false,
    'states',
])

<x-input.select class="w-full sm:w-1/2">
    <option value="{{ $currentState }}" selected>{{ $currentState->displayName() }}</option>
    @foreach ($states as $state)
        <option value="{{ $state }}">{{ get_class_name($state) }}</option>
    @endforeach
</x-input.select>
