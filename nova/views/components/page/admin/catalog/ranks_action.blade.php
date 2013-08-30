<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/catalog/ranks') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($rank, ['url' => 'admin/catalog/ranks']) }}
	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
				<label>{{ lang('Name') }}</label>
				{{ Form::text('name', null, ['class' => 'input-with-feedback form-control']) }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			{{ $errors->first('name', '<p class="help-block text-danger">:message</p>') }}
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="{{ ($errors->has('location')) ? 'form-group has-error' : '' }}">
				<label>{{ lang('Location') }}</label>
				{{ Form::text('location', null, ['class' => 'input-with-feedback form-control']) }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			{{ $errors->first('location', '<p class="help-block text-danger">:message</p>') }}
			<p class="help-block">{{ lang('short.admin.catalog.ranks.location') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="{{ ($errors->has('preview')) ? 'form-group has-error' : '' }}">
				<label>{{ lang('short.admin.catalog.previewImage') }}</label>
				{{ Form::text('preview', null, ['class' => 'input-with-feedback form-control']) }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			{{ $errors->first('preview', '<p class="help-block text-danger">:message</p>') }}
			<p class="help-block">{{ lang('short.admin.catalog.ranks.previewImageHelp') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="{{ ($errors->has('blank')) ? 'form-group has-error' : '' }}">
				<label>{{ lang('short.admin.catalog.ranks.blankImage') }}</label>
				{{ Form::text('blank', null, ['class' => 'input-with-feedback form-control']) }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			{{ $errors->first('blank', '<p class="help-block text-danger">:message</p>') }}
			<p class="help-block">{{ lang('short.admin.catalog.ranks.blankImageHelp') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-lg-2">
			<div class="{{ ($errors->has('extension')) ? 'form-group has-error' : '' }}">
				<label>{{ lang('Extension') }}</label>
				{{ Form::select('extension', ['.png' => 'PNG', '.jpg' => 'JPG', '.jpeg' => 'JPEG', '.gif' => 'GIF', '.bmp' => 'BMP'], null, ['class' => 'input-with-feedback form-control']) }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			{{ $errors->first('extension', '<p class="help-block text-danger">:message</p>') }}
			<p class="help-block">{{ lang('short.admin.catalog.ranks.extensionHelp') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-8 col-lg-6">
			<div class="form-group">
				<label>{{ lang('Credits') }}</label>
				{{ Form::textarea('credits', null, ['rows' => 5, 'class' => 'form-control']) }}
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-lg-2">
			<label>{{ lang('Genre') }}</label>
			{{ Form::text('genre', null, ['class' => 'form-control']) }}
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 has-error">
			<p class="help-block">{{ lang('short.admin.catalog.ranks.genreHelp') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-lg-2">
			<div class="form-group{{ ($errors->has('status')) ? ' has-error' : '' }}">
				<label>{{ lang('Display') }}</label>
				<div>
					<label class="radio-inline">{{ Form::radio('status', Status::ACTIVE) }} {{ lang('Yes') }}</label>
					<label class="radio-inline">{{ Form::radio('status', Status::INACTIVE) }} {{ lang('No') }}</label>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			{{ $errors->first('status', '<p class="help-block text-danger">:message</p>') }}
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			{{ Form::token() }}
			{{ Form::hidden('id') }}
			{{ Form::hidden('action', $action) }}
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}