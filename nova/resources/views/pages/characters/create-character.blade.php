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
					<label class="form-control-label">{{ _m('users', [1]) }}</label>
					<div>
						<user-picker></user-picker>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('position_id') ? ' has-danger' : '' }}">
					<label class="form-control-label">{{ _m('genre-positions', [1]) }}</label>
					<div>
						{!! Form::positions('position_id', null, null, ['placeholder' => _m('genre-positions-select'), 'class' => ($errors->has('position_id') ? ' form-control-danger' : '')]) !!}
					</div>
					{!! $errors->first('position_id', '<p class="form-control-feedback">:message</p>') !!}
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