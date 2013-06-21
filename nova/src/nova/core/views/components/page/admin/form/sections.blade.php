<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/form/index') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
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

@if ($sections !== false)
	<table class="table table-striped sort-section">
		<tbody class="sort-body">
		@foreach ($sections as $s)
			<tr id="section_{{ $s->id }}">
				<td class="col-alt-5">
					<p>
						<strong>{{ $s->name }}</strong>
						@if ($s->status === Status::INACTIVE)
							<span class="text-muted">({{ lang('Inactive') }})</span>
						<?php endif;?>
					</p>
				</td>
				<td class="col-alt-4">
					@if ($s->tab)
						<span class="text-muted">{{ $s->tab->name }}</span>
					@endif
				</td>
				<td class="col-alt-2">
					<div class="btn-toolbar pull-right">
						@if (Sentry::getUser()->hasAccess('form.update'))
							<div class="btn-group">
								<a href="{{ URL::to('admin/form/sections/'.$formKey.'/'.$s->id) }}" class="btn btn-default" >{{ $_icons['edit'] }}</a>
							</div>
						@endif

						@if (Sentry::getUser()->hasAccess('form.delete'))
							<div class="btn-group">
								<a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-danger js-section-action" data-action="delete" data-id="{{ $s->id }}">{{ $_icons['remove'] }}</a>
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
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form sections'))]) }}
@endif