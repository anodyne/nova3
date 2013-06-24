<div class="btn-group">
	<a href="{{ URL::to('admin/form') }}" class="btn btn-default icn-size-16 tooltip-top" title="{{ lang('Short.back', lang('forms')) }}">{{ $_icons['back'] }}</a>
</div>

@if ((bool) $form->form_viewer !== false)
	{{ partial('common/alert', ['class' => 'alert-danger', 'content' => lang('error.admin.formViewerNotAllowed')]) }}
@else
	@if ($entries->count() > 0)
		<table class="table table-striped">
			<thead>
				<tr>
					<th>{{ langConcat('Data id') }}</th>
					<th>{{ langConcat('Action.created On') }}</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			@foreach ($entries as $entry)
				<tr>
					<td>{{ $entry->data_id }}</td>
					<td>{{ $entry->created_at->format($_settings->date_format) }}</td>
					<td>
						<div class="btn-toolbar pull-right">
							@if (Sentry::getUser()->hasAccess('form.delete'))
								<div class="btn-group">
									<a href="{{ URL::to('admin/form/view/'.$form->key.'/detail/'.$entry->data_id) }}" class="btn btn-danger btn-small icn-size-16 pull-right">{{ $_icons['remove'] }}</a>
								</div>
							@endif

							<div class="btn-group">
								<a href="{{ URL::to('admin/form/view/'.$form->key.'/detail/'.$entry->data_id) }}" class="btn btn-default btn-small icn-size-16 pull-right">{{ $_icons['forward'] }}</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	@else
		{{ partial('common/alert', ['content' => lang('error.notFound', lang('form entries'))]) }}
	@endif
@endif