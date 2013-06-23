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

@if ($tabs !== false)
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
						<div class="btn-group icn-opacity-50">{{ $_icons['move'] }}</div>
					</div>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
@else
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form tabs'))]) }}
@endif