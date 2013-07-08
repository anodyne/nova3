<div class="visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ URL::to('admin/form') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
		</div>

		@if (Sentry::getUser()->hasAccess('form.create'))
			<div class="btn-group">
				<a href="{{ URL::to('admin/form/tabs/'.$formKey.'/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
			</div>
		@endif

		<div class="btn-group">
			<a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-default icn-size-16">{{ lang('Sections') }}</a>
			<a href="{{ URL::to('admin/form/fields/'.$formKey) }}" class="btn btn-default icn-size-16">{{ lang('Fields') }}</a>
		</div>
	</div>
</div>
<div class="hidden-lg">
	<div class="row">
		<div class="col-6">
			<p><a href="{{ URL::to('admin/form') }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['back'] }}</a></p>
		</div>

		@if (Sentry::getUser()->hasAccess('form.create'))
			<div class="col-6">
				<p><a href="{{ URL::to('admin/form/tabs/'.$formKey.'/0') }}" class="btn btn-block btn-success icn-size-16">{{ $_icons['add'] }}</a></p>
			</div>
		@endif

		<div class="col-6">
			<p><a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-block btn-default icn-size-16">{{ lang('Sections') }}</a></p>
		</div>

		<div class="col-6">
			<p><a href="{{ URL::to('admin/form/fields/'.$formKey) }}" class="btn btn-block btn-default icn-size-16">{{ lang('Fields') }}</a></p>
		</div>
	</div>
</div>

@if ($tabs !== false)
	<div class="visible-lg">
		<table class="table table-striped sort-tab">
			<tbody class="sort-body">
			@foreach ($tabs as $t)
				<tr id="tab_{{ $t->id }}">
					<td class="col-alt-9">
						<p>
							<strong>{{ $t->name }}</strong>
							@if ($t->status === Status::INACTIVE)
								<span class="text-muted">({{ lang('Inactive') }})</span>
							@endif
						</p>
					</td>
					<td class="col-alt-2">
						<div class="btn-toolbar pull-right">
							@if (Sentry::getUser()->hasAccess('form.update'))
								<div class="btn-group">
									<a href="{{ URL::to('admin/form/tabs/'.$formKey.'/'.$t->id) }}" class="btn btn-default btn-small icn-size-16">{{ $_icons['edit'] }}</a>
								</div>
							@endif

							@if (Sentry::getUser()->hasAccess('form.delete'))
								<div class="btn-group">
									<a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-danger btn-small js-tab-action icn-size-16" data-action="delete" data-id="{{ $t->id }}">{{ $_icons['remove'] }}</a>
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
		@foreach ($tabs as $t)
			<div class="col-12">
				<div class="thumbnail">
					<p><strong>{{ $t->name }}</strong></p>
					@if ($t->status === Status::INACTIVE)
						<p class="text-muted">({{ lang('Inactive') }})</p>
					@endif

					<div class="row">
						@if (Sentry::getUser()->hasAccess('form.update'))
							<div class="col-6">
								<p><a href="{{ URL::to('admin/form/tabs/'.$formKey.'/'.$t->id) }}" class="btn btn-default btn-block icn-size-16">{{ $_icons['edit'] }}</a></p>
							</div>
						@endif

						@if (Sentry::getUser()->hasAccess('form.delete'))
							<div class="col-6">
								<p><a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-danger btn-block js-tab-action icn-size-16" data-action="delete" data-id="{{ $t->id }}">{{ $_icons['remove'] }}</a></p>
							</div>
						@endif
					</div>
				</div>
			</div>
		@endforeach
		</div>
	</div>
@else
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form tabs'))]) }}
@endif