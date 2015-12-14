@if ($tabs->count() > 0)
	{!! partial('form-tabs-control', ['tabs' => $parentTabs, 'style' => 'tabs']) !!}

	{!! partial('form-tabs-content', ['tabs' => $parentTabs]) !!}
@endif