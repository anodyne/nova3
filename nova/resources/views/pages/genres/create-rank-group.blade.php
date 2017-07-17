@extends('layouts.app')

@section('title', _m('genre-rank-groups-add'))

@section('content')
	<h1>{{ _m('genre-rank-groups-add') }}</h1>

	{!! Form::open(['route' => 'ranks.groups.store']) !!}
		<div class="row">
			<div class="col-md-4">
				<div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
					<label class="form-control-label">{{ _m('name') }}</label>
					{!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' form-control-danger' : '')]) !!}
					{!! $errors->first('name', '<p class="form-control-feedback">:message</p>') !!}
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
			<button type="submit" class="btn btn-primary">{{ _m('genre-rank-groups-add') }}</button>
			<a href="{{ route('ranks.groups.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
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