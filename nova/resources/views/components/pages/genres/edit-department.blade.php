<h1>{{ _m('genre-depts-update') }}</h1>

{!! Form::model($department, ['route' => ['departments.update', $department], 'method' => 'patch']) !!}
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label>{{ _m('name') }}</label>
				{!! Form::text('name', null, ['class' => 'form-control'.($errors->has('name') ? ' is-invalid' : '')]) !!}
				{!! $errors->first('name', '<p class="invalid-feedback">:message</p>') !!}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>{{ _m('description') }}</label>
				{!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 8]) !!}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label>{{ _m('genre-depts-parent') }}</label>
				<div>
					{!! Form::departments('parent_id', null, null, ['placeholder' => _m('genre-depts-parent-none')], true) !!}
				</div>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label>{{ _m('displayed') }}</label>
		<div>
			<toggle-button class="toggle-switch lg"
						   :value="{{ ($department->display == 1) ? 'true' : 'false' }}"
						   @change="toggleDisplay"></toggle-button>
			<input type="hidden" name="display" v-model="display">
		</div>
	</div>

	<div class="form-group">
		<button type="submit" class="btn btn-primary">{{ _m('genre-depts-update') }}</button>
		<a href="{{ route('departments.index') }}" class="btn btn-link">{{ _m('cancel') }}</a>
	</div>
{!! Form::close() !!}