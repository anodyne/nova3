@extends('layouts.app')

@section('title', _m('genre-rank-info-add'))

@section('content')
	<h1>{{ _m('genre-rank-info-add') }}</h1>

	{!! Form::open(['route' => 'ranks.info.store']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label">{{ _m('name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : '')]) !!}
					{!! $errors->first('name', '<p class="invalid-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label class="form-control-label">{{ _m('genre-rank-info-short_name') }}</label>
					{!! Form::text('short_name', null, ['class' => 'form-control'.($errors->has('short_name') ? ' is-invalid' : '')]) !!}
					{!! $errors->first('short_name', '<p class="invalid-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('genre-rank-info-add') }}</button>
			<a href="{{ route('ranks.info.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection