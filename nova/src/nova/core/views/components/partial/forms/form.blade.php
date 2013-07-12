@if (count($tabs) > 0)
	<ul class="nav nav-tabs">
	@foreach ($tabs as $t)
		<li><a href="#{{ $t['tab']->link_id }}" data-toggle="tab">{{ $t['tab']->name }}</a></li>
	@endforeach
	</ul>
	
	<div class="tab-content">
	@foreach ($tabs as $t)
		<div class="tab-pane" id="{{ $t['tab']->link_id }}">
			@if (array_key_exists('fields', $t))
				@foreach ($t['fields'] as $field)
					{{ partial('forms/field', ['field' => $field, 'data' => $t['data'], 'editable' => $editable]) }}
				@endforeach
			@endif

			@if (array_key_exists('sections', $t))
				@foreach ($t['sections'] as $section)
					{{ partial('forms/section', ['fields' => $section->fields, 'section' => $section, 'data' => $t['data'], 'editable' => $editable]) }}
				@endforeach
			@endif
		</div>
	@endforeach
	</div>
@else
	@if (count($sections) > 0)
		@foreach ($sections as $s)
			{{ partial('forms/section', ['fields' => $s['fields'], 'section' => $s['section'], 'data' => $s['data'], 'editable' => $editable]) }}
		@endforeach
	@else
		@if (count($fields) > 0)
			@foreach ($fields as $f)
				{{ partial('forms/field', ['field' => $f['field'], 'data' => $f['data'], 'editable' => $editable]) }}
			@endforeach
		@endif
	@endif
@endif