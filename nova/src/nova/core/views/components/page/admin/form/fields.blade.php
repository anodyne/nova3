<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/form') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>

	@if (Sentry::getUser()->hasAccess('form.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/form/fields/'.$formKey.'/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif

	<div class="btn-group">
		<a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-default icn-size-16">{{ lang('Tabs') }}</a>
		<a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-default icn-size-16">{{ lang('Sections') }}</a>
	</div>
</div>

@if ($fields !== false)
	<table class="table table-striped sort-field">
		<tbody class="sort-body">
		@foreach ($fields as $f)
			<tr id="field_{{ $f->id }}">
				<td class="col-alt-4">
					<label class="control-label">
						{{ $f->label }}
						@if ($f->status === Status::INACTIVE)
							<span class="text-muted">({{ lang('Inactive') }})</span>
						@endif
					</label>
					<div class="controls">
						@if ($f->type == 'text')
							{{ Form::text($f->html_name, $f->value, ['class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder]) }}
						@elseif ($f->type == 'textarea')
							{{ Form::textarea($f->html_name, $f->value, ['class' => $f->html_class, 'id' => $f->html_id, 'placeholder' => $f->placeholder, 'rows' => $f->html_rows]) }}
						@elseif ($f->type == 'select')
							{{ Form::select($f->html_name, $f->getValues(), $f->value, ['class' => $f->html_class, 'id' => $f->html_id]);?>
						@endif
					</div>
				</td>
				<td class="col-alt-5"></td>
				<td class="col-alt-2">
					<div class="btn-toolbar pull-right">
						@if (Sentry::getUser()->hasAccess('form.update'))
							<div class="btn-group">
								<a href="{{ URL::to('admin/form/fields/'.$formKey.'/'.$f->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
							</div>
						@endif

						@if (Sentry::getUser()->hasAccess('form.delete'))
							<div class="btn-group">
								<a href="{{ URL::to('admin/form/fields/'.$formKey);?>" class="btn btn-small btn-danger js-field-action icn-size-16" data-action="delete" data-id="{{ $f->id }}">{{ $_icons['remove'] }}</a>
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
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form fields'))]) }}
@endif