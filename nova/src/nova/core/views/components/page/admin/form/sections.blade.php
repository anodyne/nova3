<div class="visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ URL::to('admin/form') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
		</div>

		@if (Sentry::getUser()->hasAccess('form.create'))
			<div class="btn-group">
				<a href="{{ URL::to('admin/form/sections/'.$formKey.'/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
			</div>
		@endif

		<div class="btn-group">
			<a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-default icn-size-16">{{ lang('Tabs') }}</a>
			<a href="{{ URL::to('admin/form/fields/'.$formKey) }}" class="btn btn-default icn-size-16">{{ lang('Fields') }}</a>
		</div>
	</div>	
</div>
<div class="hidden-lg">
	<div class="row">
		<div class="col-6">
			<p><a href="{{ URL::to('admin/form') }}" class="btn btn-default btn-block icn-size-16">{{ $_icons['back'] }}</a></p>
		</div>

		@if (Sentry::getUser()->hasAccess('form.create'))
			<div class="col-6">
				<p><a href="{{ URL::to('admin/form/sections/'.$formKey.'/0') }}" class="btn btn-success btn-block icn-size-16">{{ $_icons['add'] }}</a></p>
			</div>
		@endif

		<div class="col-6">
			<p><a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-default btn-block icn-size-16">{{ lang('Tabs') }}</a></p>
		</div>

		<div class="col-6">
			<p><a href="{{ URL::to('admin/form/fields/'.$formKey) }}" class="btn btn-default btn-block icn-size-16">{{ lang('Fields') }}</a></p>
		</div>
	</div>
</div>

@if ($tabs !== false)
	<div class="hidden-sm">
		<ul class="nav nav-tabs">
		@foreach ($tabs as $tab)
			<li><a href="#{{ $tab->link_id }}" data-toggle="tab">{{ $tab->name }}</a></li>
		@endforeach
		</ul>
	</div>
	<div class="visible-sm">
		<ul class="nav nav-pills">
		@foreach ($tabs as $tab)
			<li><a href="#{{ $tab->link_id }}" data-toggle="tab">{{ $tab->name }}</a></li>
		@endforeach
		</ul>
	</div>

	<div class="tab-content">
	@foreach ($tabs as $tab)
		<div id="{{ $tab->link_id }}" class="tab-pane">
		@if ($sections !== false and isset($sections[$tab->id]))
			<div class="visible-lg">
				<table class="table table-striped sort-section">
					<tbody class="sort-body">
					@foreach ($sections[$tab->id] as $s)
						<tr id="section_{{ $s->id }}">
							<td class="col-alt-9">
								<p>
									<strong>{{ $s->name }}</strong>
									@if ($s->status === Status::INACTIVE)
										<span class="text-muted">({{ lang('Inactive') }})</span>
									<?php endif;?>
								</p>
							</td>
							<td class="col-alt-2">
								<div class="btn-toolbar pull-right">
									@if (Sentry::getUser()->hasAccess('form.update'))
										<div class="btn-group">
											<a href="{{ URL::to('admin/form/sections/'.$formKey.'/'.$s->id) }}" class="btn btn-small btn-default icn-size-16" >{{ $_icons['edit'] }}</a>
										</div>
									@endif

									@if (Sentry::getUser()->hasAccess('form.delete'))
										<div class="btn-group">
											<a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-small btn-danger js-section-action icn-size-16" data-action="delete" data-id="{{ $s->id }}">{{ $_icons['remove'] }}</a>
										</div>
									@endif
								</div>
							</td>
							<td class="col-alt-1">
								<div class="btn-toolbar pull-right">
									<div class="btn-group icn-opacity-50 reorder">{{ $_icons['move'] }}</div>
								</div>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			<div class="hidden-lg">
				<div class="row">
				@foreach ($sections[$tab->id] as $s)
					<div class="col-12">
						<div class="thumbnail">
							<p><strong>{{ $s->name }}</strong></p>
							@if ($s->status === Status::INACTIVE)
								<p class="text-muted">({{ lang('Inactive') }})</p>
							@endif

							<div class="row">
								@if (Sentry::getUser()->hasAccess('form.update'))
									<div class="col-6">
										<p><a href="{{ URL::to('admin/form/sections/'.$formKey.'/'.$s->id) }}" class="btn btn-default btn-block icn-size-16" >{{ $_icons['edit'] }}</a></p>
									</div>
								@endif

								@if (Sentry::getUser()->hasAccess('form.delete'))
									<div class="col-6">
										<p><a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-danger btn-block js-section-action icn-size-16" data-action="delete" data-id="{{ $s->id }}">{{ $_icons['remove'] }}</a></p>
									</div>
								@endif
							</div>
						</div>
					</div>
				@endforeach
				</div>
			</div>
		@else
			{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form sections'))]) }}
		@endif
		</div>
	@endforeach
	</div>
@else
	@if ($sections !== false)
		<div class="visible-lg">
			<table class="table table-striped sort-section">
				<tbody class="sort-body">
				@foreach ($sections as $s)
					<tr id="section_{{ $s->id }}">
						<td class="col-alt-9">
							<p>
								<strong>{{ $s->name }}</strong>
								@if ($s->status === Status::INACTIVE)
									<span class="text-muted">({{ lang('Inactive') }})</span>
								<?php endif;?>
							</p>
						</td>
						<td class="col-alt-2">
							<div class="btn-toolbar pull-right">
								@if (Sentry::getUser()->hasAccess('form.update'))
									<div class="btn-group">
										<a href="{{ URL::to('admin/form/sections/'.$formKey.'/'.$s->id) }}" class="btn btn-default btn-small icn-size-16" >{{ $_icons['edit'] }}</a>
									</div>
								@endif

								@if (Sentry::getUser()->hasAccess('form.delete'))
									<div class="btn-group">
										<a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-danger btn-small icn-size-16 js-section-action" data-action="delete" data-id="{{ $s->id }}">{{ $_icons['remove'] }}</a>
									</div>
								@endif
							</div>
						</td>
						<td class="col-alt-1">
							<div class="btn-toolbar pull-right">
								<div class="btn-group icn-opacity-50 reorder">{{ $_icons['move'] }}</div>
							</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		<div class="hidden-lg">
			<div class="row">
			@foreach ($sections as $s)
				<div class="col-12">
					<div class="thumbnail">
						<p><strong>{{ $s->name }}</strong></p>
						@if ($s->status === Status::INACTIVE)
							<p class="text-muted">({{ lang('Inactive') }})</p>
						@endif

						<div class="row">
							@if (Sentry::getUser()->hasAccess('form.update'))
								<div class="col-6">
									<p><a href="{{ URL::to('admin/form/sections/'.$formKey.'/'.$s->id) }}" class="btn btn-default btn-block icn-size-16" >{{ $_icons['edit'] }}</a></p>
								</div>
							@endif

							@if (Sentry::getUser()->hasAccess('form.delete'))
								<div class="col-6">
									<p><a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-danger btn-block js-section-action icn-size-16" data-action="delete" data-id="{{ $s->id }}">{{ $_icons['remove'] }}</a></p>
								</div>
							@endif
						</div>
					</div>
				</div>
			@endforeach
			</div>
		</div>
	@else
		{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form sections'))]) }}
	@endif
@endif