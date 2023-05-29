@props([
	'action',
	'footer' => false,
	'method' => 'POST',
	'divide' => true,
	'space' => true,
])

<form
	action="{{ $action }}"
	method="{{ $method === 'GET' ?: 'POST' }}"
	role="form"
	{{ $attributes->merge(['data-cy' => 'form']) }}
>
	@csrf

	@unless (in_array($method, ['GET', 'POST']))
		@method($method)
	@endunless

	<div @class([
		'divide-y divide-gray-100 dark:divide-gray-800' => $divide,
		'space-y-8' => $space,
	])>
		{{ $slot }}
	</div>
</form>
