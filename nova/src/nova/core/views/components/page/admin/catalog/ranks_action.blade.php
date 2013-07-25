<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/catalog/ranks') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($rank, ['url' => 'admin/catalog/ranks']) }}
	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="control-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
				<label class="control-label">{{ lang('Name') }}</label>
				<div class="controls">
					{{ Form::text('name', null, ['class' => 'input-with-feedback']) }}
				</div>
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
			<div class="{{ ($errors->has('location')) ? 'control-group has-error' : '' }}">
				<label class="control-label">{{ lang('Location') }}</label>
				<div class="controls">
					{{ Form::text('location', null, ['class' => 'input-with-feedback']) }}
				</div>
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
			<div class="{{ ($errors->has('preview')) ? 'control-group has-error' : '' }}">
				<label class="control-label">{{ lang('short.admin.catalog.ranks.previewImage') }}</label>
				<div class="controls">
					{{ Form::text('preview', null, ['class' => 'input-with-feedback']) }}
				</div>
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
			<div class="{{ ($errors->has('blank')) ? 'control-group has-error' : '' }}">
				<label class="control-label">{{ lang('short.admin.catalog.ranks.blankImage') }}</label>
				<div class="controls">
					{{ Form::text('blank', null, ['class' => 'input-with-feedback']) }}
				</div>
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
			<div class="{{ ($errors->has('extension')) ? 'control-group has-error' : '' }}">
				<label class="control-label">{{ lang('Extension') }}</label>
				<div class="controls">
					{{ Form::select('extension', ['.png' => 'PNG', '.jpg' => 'JPG', '.jpeg' => 'JPEG', '.gif' => 'GIF', '.bmp' => 'BMP'], null, ['class' => 'input-with-feedback']) }}
				</div>
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
			<div class="control-group">
				<label class="control-label">{{ lang('Credits') }}</label>
				<div class="controls">{{ Form::textarea('credits', null, ['rows' => 5]) }}</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-lg-2">
			<label class="control-label">{{ lang('Genre') }}</label>
			<div class="controls">{{ Form::text('genre') }}</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12 has-error">
			<p class="help-block">{{ lang('short.admin.catalog.ranks.genreHelp') }}</p>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-lg-2">
			<div class="control-group{{ ($errors->has('status')) ? ' has-error' : '' }}">
				<label class="control-label">{{ lang('Display') }}</label>
				<div class="controls">
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