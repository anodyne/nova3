@extends('layouts.app')

@section('title', _m('characters-add'))

@section('content')
	<h1>{{ _m('characters-add') }}</h1>

	{!! Form::open(['route' => 'characters.store']) !!}
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
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label">{{ _m('genre-positions', [1]) }}</label>
					{!! Form::text('position_id', 1, ['class' => 'form-control']) !!}
					<div>
						{!! Form::positions('position_id') !!}
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label">{{ _m('genre-ranks', [1]) }}</label>
					<div>
						<rank-picker></rank-picker>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('characters-add') }}</button>
			<a href="{{ route('characters.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection