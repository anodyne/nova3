@extends('layouts.app')

@section('title', _m('genre-depts-add'))

@section('content')
	<h1>{{ _m('genre-depts-add') }}</h1>

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
					<label class="form-control-label">{{ _m('genre-depts-parent') }}</label>
					<div>
						{!! Form::departments('parent_id', null, null, ['placeholder' => _m('genre-depts-parent-none')], true) !!}
					</div>
				</div>
			</div>
		</div>

		<fieldset>
			<legend>{{ _m('genre-positions-add', [2]) }}</legend>

			<div class="row">
				<div class="col-md-6">
					<div class="data-table bordered striped">
						<div class="row d-flex align-items-center" v-for="(position, index) in positions">
							<div class="col">
								<input type="text" name="positions[][name]" class="form-control" v-model="position.name" placeholder="{{ _m('name') }}">
							</div>
							<div class="col col-auto">
								<a href="#"
								   class="btn btn-sm btn-outline-danger btn-action"
								   @click.prevent="removePosition(index)">{!! icon('delete') !!}</a>
							</div>
						</div>
					</div>

					<div class="form-group mb-5">
						<a href="#" class="btn btn-sm btn-secondary" @click.prevent="addPosition">
							{{ _m('genre-positions-add-another') }}
						</a>
					</div>
				</div>
			</div>
		</fieldset>

		<div class="form-group">
			<button type="submit" class="btn btn-primary">{{ _m('genre-depts-add') }}</button>
			<a href="{{ route('departments.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
		</div>
	{!! Form::close() !!}
@endsection

@section('js')
	<script>
		vue = {
			data: {
				positions: [{name:''}]
			},

			methods: {
				addPosition () {
					this.positions.push({name:''})
				},

				removePosition (index) {
					this.positions.splice(index, 1)
				}
			}
		}
	</script>
@endsection