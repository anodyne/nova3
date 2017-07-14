@extends('layouts.app')

@section('title', _m('genre-dept-add'))

@section('content')
	<h1>{{ _m('genre-dept-add') }}</h1>

	{!! Form::open(['route' => 'departments.store']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
					<label class="form-control-label">{{ _m('name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' form-control-danger' : '')]) !!}
					{!! $errors->first('name', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label class="form-control-label">{{ _m('description') }}</label>
					{!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4]) !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label">{{ _m('genre-dept-parent') }}</label>
					<div>
						{!! Form::departments('parent_id', null, null, ['placeholder' => _m('genre-dept-parent-none')], true) !!}
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('genre-dept-add') }}</button>
			<a href="{{ route('departments.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection