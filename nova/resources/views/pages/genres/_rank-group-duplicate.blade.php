<p>{{ _m('genre-rank-groups-confirm-duplicate-message') }}</p>

{!! Form::open(['route' => ['ranks.groups.duplicate', $group], 'id' => 'duplicateForm']) !!}
	<div class="form-group">
		<label class="form-control-label">{{ _m('name') }}</label>
		{!! Form::text('name', null, ['class' => 'form-control']) !!}
	</div>

	<div class="form-group">
		<label class="form-control-label">{{ _m('genre-rank-groups-new-base-image') }}</label>
		<div>{!! Form::select('base', $baseImages, null, ['class' => 'custom-select']) !!}</div>
	</div>
{!! Form::close() !!}