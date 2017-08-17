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
				<div class="form-group">
					<label class="form-control-label">{{ _m('genre-ranks', [1]) }}</label>
					<div>
						<rank-picker></rank-picker>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<fieldset>
					<legend>{{ _m('genre-positions', [2]) }}</legend>
				</fieldset>

				<div class="form-group" v-for="(position, index) in positions">
					<div class="d-flex align-items-center">
						{!! Form::positions('positions[]', null, null, ['placeholder' => _m('genre-positions-select'), 'v-model' => 'position.id', 'class' => ($errors->has('positions') ? ' is-invalid' : '')]) !!}
						
						<a href="#" class="text-secondary mx-2" @click.prevent="addPosition">{!! icon('add-alt') !!}</a>
						<a href="#"
						   class="text-danger"
						   v-show="positions.length > 1"
						   @click.prevent="removePosition(index)">{!! icon('minus') !!}</a>
					</div>
					{!! $errors->first('positions', '<p class="invalid-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('characters-add') }}</button>
			<a href="{{ route('characters.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection

@section('js')
	<script>
		vue = {
			data: {
				positions: [{ id:'' }]
			},

			methods: {
				addPosition () {
					this.positions.push({ id:'' })
				},

				removePosition (index) {
					this.positions.splice(index, 1)
				}
			}
		}
	</script>
@endsection