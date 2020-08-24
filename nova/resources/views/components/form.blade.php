@props([
    'action',
    'footer' => false,
    'method' => 'POST',
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

    <div class="divide-y divide-gray-100 space-y-4 | md:space-y-8">
        {{ $slot }}
    </div>
</form>
