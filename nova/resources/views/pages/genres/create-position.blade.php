@extends('layouts.app')

@section('title', _m('genre-positions-add', [1]))

@section('content')
	<h1>{{ _m('genre-positions-add', [1]) }}</h1>

	{!! Form::open(['route' => 'positions.store']) !!}
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
			<div class="col-md-8">
				<div class="form-group">
					<label class="form-control-label">{{ _m('description') }}</label>
					{!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 5]) !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group{{ $errors->has('department_id') ? ' has-danger' : '' }}">
					<label class="form-control-label">{{ _m('genre-depts', [1]) }}</label>
					<div>
						{!! Form::departments('department_id', null, null, ['placeholder' => _m('genre-depts-select')]) !!}
					</div>
					{!! $errors->first('department_id', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<label class="form-control-label">{{ _m('genre-positions-available') }}</label>
					{!! Form::number('available', 1, ['class' => 'form-control']) !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="form-control-label">{{ _m('displayed') }}</label>
			<div>
				<toggle-button class="toggle-switch lg" :value="true" @change="toggleDisplay"></toggle-button>
				<input type="hidden" name="display" v-model="display">
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('genre-positions-add', [1]) }}</button>
			<a href="{{ route('positions.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection

@section('js')
	<script>
		vue = {
			data: {
				display: 1
			},

			methods: {
				toggleDisplay (event) {
					this.display = (event.value === true) ? 1 : 0
				}
			}
		}
	</script>
@endsection