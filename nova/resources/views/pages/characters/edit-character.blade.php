@extends('layouts.app')

@section('title', _m('characters-update'))

@section('content')
	<h1>{{ _m('characters-update') }}</h1>

	{!! Form::model($character, ['route' => ['characters.update', $character], 'method' => 'patch']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
					<label>{{ _m('name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' form-control-danger' : '')]) !!}
					{!! $errors->first('name', '<p class="form-control-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label>{{ _m('users', [1]) }}</label>
					<div>
						@if ($character->user)
							<user-picker :selected="{{ $character->user }}"></user-picker>
						@else
							<user-picker></user-picker>
						@endif
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-4">
				<div class="form-group">
					<label>{{ _m('genre-ranks', [1]) }}</label>
					<div>
						@if ($character->rank)
							<rank-picker :selected="{{ $character->rank }}"></rank-picker>
						@else
							<rank-picker></rank-picker>
						@endif
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 col-lg-5">
				<label>{{ _m('genre-positions', [2]) }}</label>

				<div class="form-group" v-for="(position, index) in positions">
					<div class="d-flex align-items-center">
						<position-picker :selected="position">
							<a href="#" class="text-secondary mx-2" @click.prevent="addPosition">{!! icon('add-alt') !!}</a>
							<a href="#"
							   class="text-danger"
							   v-show="positions.length > 1"
							   @click.prevent="removePosition(index)">{!! icon('minus') !!}</a>
						</position-picker>
					</div>
					{!! $errors->first('positions', '<p class="invalid-feedback">:message</p>') !!}
				</div>
			</div>
		</div>

		<fieldset>
			<legend>{{ _m('image', [2]) }}</legend>

			<media-manager :item="{{ $character }}" type="character"></media-manager>
		</fieldset>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('characters-update') }}</button>
			<a href="{{ route('characters.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection

@section('js')
	<script>
		vue = {
			data: {
				positions: {!! $character->positions !!}
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