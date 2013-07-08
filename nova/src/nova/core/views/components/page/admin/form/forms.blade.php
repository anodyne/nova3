<div class="btn-toolbar visible-lg">
	<div class="btn-group">
	@if (Sentry::getUser()->hasAccess('form.create'))
		<a href="{{ URL::to('admin/form/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
	@endif
	</div>
</div>

<div class="row hidden-lg">
	<div class="col-4">
		@if (Sentry::getUser()->hasAccess('form.create'))
			<p><a href="{{ URL::to('admin/form/0') }}" class="btn btn-success btn-block icn-size-16">{{ $_icons['add'] }}</a></p>
		@endif
	</div>
</div>

@if ($forms->count() > 0)
	<div class="row">
	@foreach ($forms as $form)
		<div class="col-lg-6">
			<div class="thumbnail">
				@if (Sentry::getUser()->hasAccess('form.update') or Sentry::getUser()->hasAccess('form.delete'))
					<div class="btn-group pull-right dropdown">
						<a class="btn btn-default btn-small icn-size-16 dropdown-toggle" data-toggle="dropdown" href="#">{{ $_icons['settings'] }}</a>
						<ul class="dropdown-menu">
							@if (Sentry::getUser()->hasAccess('form.update'))
								<li>
									<a href="{{ URL::to('admin/form/'.$form->key) }}">
										{{ lang('Short.edit', lang('form')) }}
									</a>
								</li>
								<li>
									<a href="{{ URL::to('admin/form/tabs/'.$form->key) }}">
										{{ lang('Short.edit', lang('tabs')) }}
									</a>
								</li>
								<li>
									<a href="{{ URL::to('admin/form/sections/'.$form->key) }}">
										{{ lang('Short.edit', lang('sections')) }}
									</a>
								</li>
								<li>
									<a href="{{ URL::to('admin/form/fields/'.$form->key) }}">
										{{ lang('Short.edit', lang('fields')) }}
									</a>
								</li>
							@endif

							@if (Sentry::getUser()->hasAccess('form.delete') and (bool) $form->protected === false)
								<li class="divider"></li>
								<li>
									<a href="#" class="js-form-action" data-key="{{ $form->key }}" data-action="delete">
										{{ lang('Short.delete', lang('form')) }}
									</a>
								</li>
							@endif

							@if ((bool) $form->form_viewer === true)
								<li class="divider"></li>
								<li>
									<a href="{{ URL::to('admin/formviewer/add/'.$form->key) }}">
										{{ lang('Short.fillout', lang('form')) }}
									</a>
								</li>
								<li>
									<a href="{{ URL::to('admin/formviewer/view/'.$form->key) }}">
										{{ lang('Short.view', lang('form')) }}
									</a>
								</li>
							@endif
						</ul>
					</div>
				@endif

				<h4>{{ $form->name }}</h4>
			</div>
		</div>
	@endforeach
	</div>
@endif