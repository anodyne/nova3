@if ($tabs->count() > 0)
	{!! partial('form-tabs-control', ['tabs' => $tabs, 'style' => 'tabs']) !!}

	{!! partial('form-tabs-content', ['tabs' => $tabs]) !!}
@endif