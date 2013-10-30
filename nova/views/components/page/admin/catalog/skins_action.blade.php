<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/catalog/skins') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::model($skin, ['url' => 'admin/catalog/skins']) }}
	@if (isset($options))
		<ul class="nav nav-tabs">
			<li class="active"><a href="#basicInfo" data-toggle="tab">{{ langConcat('Basic Info') }}</a></li>
			<li><a href="#skinOptions" data-toggle="tab">{{ langConcat('Skin Options') }}</a></li>
		</ul>
	@endif

	<div class="tab-content">
		<div id="basicInfo" class="active tab-pane">
			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
						<label class="control-label">{{ lang('Name') }}</label>
						{{ Form::text('name', null, ['class' => 'form-control']) }}
						{{ $errors->first('name', '<p class="help-block">:message</p>') }}
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="{{ ($errors->has('location')) ? 'form-group has-error' : '' }}">
						<label class="control-label">{{ lang('Location') }}</label>
						{{ Form::text('location', null, ['class' => 'form-control']) }}
						{{ $errors->first('location', '<p class="help-block">:message</p>') }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.catalog.skins.location') }}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="{{ ($errors->has('nav')) ? 'form-group has-error' : '' }}">
						<label class="control-label">{{ lang('short.admin.catalog.skins.menuStyle') }}</label>
						{{ Form::select('nav', ['dropdown' => lang('Dropdown'), 'classic' => lang('Classic_menu')], null, ['class' => 'form-control']) }}
						{{ $errors->first('nav', '<p class="help-block">:message</p>') }}
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.catalog.skins.menuStyleHelp') }}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<label class="control-label">{{ lang('short.admin.catalog.previewImage') }}</label>
					{{ Form::text('preview', null, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.catalog.skins.previewImageHelp') }}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4 col-lg-2">
					<div class="form-group">
						<label class="control-label">{{ lang('short.admin.catalog.skins.hasMain') }}</label>
						<div>
							<label class="radio-inline">{{ Form::radio('has_main', (int) true) }} {{ lang('Yes') }}</label>
							<label class="radio-inline">{{ Form::radio('has_main', (int) false) }} {{ lang('No') }}</label>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4 col-lg-2">
					<div class="form-group">
						<label class="control-label">{{ lang('short.admin.catalog.skins.hasAdmin') }}</label>
						<div>
							<label class="radio-inline">{{ Form::radio('has_admin', (int) true) }} {{ lang('Yes') }}</label>
							<label class="radio-inline">{{ Form::radio('has_admin', (int) false) }} {{ lang('No') }}</label>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4 col-lg-2">
					<div class="form-group">
						<label class="control-label">{{ lang('short.admin.catalog.skins.hasLogin') }}</label>
						<div>
							<label class="radio-inline">{{ Form::radio('has_login', (int) true) }} {{ lang('Yes') }}</label>
							<label class="radio-inline">{{ Form::radio('has_login', (int) false) }} {{ lang('No') }}</label>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-8 col-lg-6">
					<div class="form-group">
						<label class="control-label">{{ lang('Credits') }}</label>
						{{ Form::textarea('credits', null, ['rows' => 5, 'class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4 col-lg-2">
					<div class="form-group">
						<label class="control-label">{{ lang('Version') }}</label>
						{{ Form::text('version', null, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="form-group{{ ($errors->has('status')) ? ' has-error' : '' }}">
						<label class="control-label">{{ lang('Display') }}</label>
						<div>
							<label class="radio-inline">{{ Form::radio('status', Status::ACTIVE) }} {{ lang('Yes') }}</label>
							<label class="radio-inline">{{ Form::radio('status', Status::INACTIVE) }} {{ lang('No') }}</label>
							{{ $errors->first('status', '<p class="help-block">:message</p>') }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="skinOptions" class="tab-pane">
			@if (isset($options))
				@foreach ($options->items as $o)
					<div class="row">
						@if ($o->type != "textarea")
							<div class="col-sm-6 col-lg-4">
						@else
							<div class="col-sm-8 col-lg-6">
						@endif

							@if (empty($o->help))
								<div class="form-group">
							@endif

							<label class="control-label">{{ $o->label }}</label>

							@if ($o->type == "text")
								{{ Form::text('options['.$o->key.']', ((isset($skin->options[$o->key])) ? $skin->options[$o->key] : null), ['class' => 'form-control']) }}
							@elseif ($o->type == "textarea")
								{{ Form::textarea('options['.$o->key.']', ((isset($skin->options[$o->key])) ? $skin->options[$o->key] : null), ['rows' => 3, 'class' => 'form-control']) }}
							@elseif ($o->type == "choice")
								{{ Form::select('options['.$o->key.']', array_combine($o->options, $o->options), ((isset($skin->options[$o->key])) ? $skin->options[$o->key] : null), ['class' => 'form-control']) }}
							@elseif ($o->type == "image")
								@if (isset($skin->options[$o->key]))
									<p><code>{{ $skin->options[$o->key] }}</code></p>
								@endif

								<div class="well dropzone-upload visible-lg" id="{{ $o->key }}">
									<div class="icn-size-64 icn-opacity-25 text-center">{{ $_icons['upload'] }}</div>
									<div class="icn-size-32 text-success text-center hidden">{{ $_icons['check'] }}</div>
									<div class="icn-size-32 text-danger text-center hidden">{{ $_icons['warning'] }}</div>
								</div>

								<p class="help-block visible-lg">{{ lang('short.admin.catalog.skins.imageUploadHelp') }}</p>
							@endif

							@if (empty($o->help))
								</div>
							@endif
						</div>
					</div>

					@if ( ! empty($o->help))
						<div class="row">
							<div class="col-lg-12">
								<p class="help-block">{{ $o->help }}</p>
							</div>
						</div>
					@endif
				@endforeach
			@endif
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			{{ Form::token() }}
			{{ Form::hidden('id') }}
			{{ Form::hidden('formAction', $action) }}
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}