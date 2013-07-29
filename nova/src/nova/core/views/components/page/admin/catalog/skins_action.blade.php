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
					<div class="form-group">
						<label>{{ lang('Name') }}</label>
						{{ Form::text('name', null, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<label>{{ lang('Location') }}</label>
					{{ Form::text('location', null, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.catalog.skins.location') }}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<label>{{ lang('short.admin.catalog.skins.menuStyle') }}</label>
					{{ Form::select('nav', ['dropdown' => lang('Dropdown'), 'classic' => lang('Classic_menu')], null, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.catalog.skins.menuStyleHelp') }}</p>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<label>{{ lang('short.admin.catalog.previewImage') }}</label>
					{{ Form::text('preview', null, ['class' => 'form-control']) }}
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="help-block">{{ lang('short.admin.catalog.skins.previewImageHelp') }}</p>
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
					<div class="form-group">
						<label>{{ lang('Version') }}</label>
						{{ Form::text('version', null, ['class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-4 col-lg-2">
					<div class="form-group">
						<label>{{ lang('Display') }}</label>
						<div>
							<label class="radio-inline">{{ Form::radio('status', Status::ACTIVE) }} {{ lang('Yes') }}</label>
							<label class="radio-inline">{{ Form::radio('status', Status::INACTIVE) }} {{ lang('No') }}</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div id="skinOptions" class="tab-pane">
			@if (isset($options))
				@foreach ($options->items as $o)
					<div class="row">
						@if ($o->type == "text" or $o->type == "choice")
							<div class="col-sm-6 col-lg-4">
						@else
							<div class="col-sm-8 col-lg-6">
						@endif

							@if (empty($o->help))
								<div class="form-group">
							@endif

							<label>{{ $o->label }}</label>

							@if ($o->type == "text")
								{{ Form::text($o->key, null, ['class' => 'form-control']) }}
							@elseif ($o->type == "textarea")
								{{ Form::textarea($o->key, null, ['rows' => 3, 'class' => 'form-control']) }}
							@elseif ($o->type == "choice")
								{{ Form::select($o->key, array_combine($o->options, $o->options), null, ['class' => 'form-control']) }}
							@elseif ($o->type == "image")

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
			{{ Form::hidden('action', $action) }}
			{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		</div>
	</div>
{{ Form::close() }}