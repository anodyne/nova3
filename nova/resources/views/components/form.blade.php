@props([
    'action',
    'footer' => false,
    'method' => 'POST',
    'divide' => true,
])

<form
    action="{{ $action }}"
    method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
    role="form"
    {{ $attributes->merge(['data-cy' => 'form']) }}
>
    @csrf

    @if (! in_array($method, ['GET', 'POST']))
        @method($method)
    @endif

    <div class="@if ($divide) divide-y divide-gray-100 @endif space-y-4 | md:space-y-8">
        {{ $slot }}
    </div>
</form>
