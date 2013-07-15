<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/form') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>

	<div class="btn-group">
		<a href="{{ URL::to('admin/formviewer/'.$formKey.'/add') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
	</div>
</div>

@if ((bool) $form->protected === false)
	@if ($entries->count() > 0)
		<div class="row">
			<div class="col-12 col-sm-6 col-lg-4">
				<div class="control-group">
					{{ Form::text('', null, ['id' => 'searchEntries', 'placeholder' => lang('Short.search', langConcat('for Entry'))]) }}
				</div>
			</div>
		</div>

		<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="entriesSearch">
			@foreach ($entries as $e)
				<div class="row">
					<div class="col-12 col-sm-8 col-lg-9">
						@if ($hasDisplayField)
							<p><strong>{{ $e->value }}</strong></p>
						@else
							<p><strong>{{ $e->created_at }}</strong></p>
						@endif
					</div>
					<div class="col-12 col-sm-4 col-lg-3">
						<div class="hidden-sm">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									@if (Sentry::getUser()->hasAccess('form.read'))
										<a href="{{ URL::to('admin/formviewer/'.$form->key.'/detail/'.$e->data_id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['view'] }}</a>
									@endif

									@if (Sentry::getUser()->hasAccess('form.update'))
										<a href="{{ URL::to('admin/formviewer/'.$form->key.'/update/'.$e->data_id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
									@endif
								</div>

								@if (Sentry::getUser()->hasAccess('form.delete'))
									<div class="btn-group">
										<a href="#" class="btn btn-small btn-danger js-tab-action icn-size-16" data-action="delete" data-id="{{ $e->data_id }}">{{ $_icons['remove'] }}</a>
									</div>
								@endif
							</div>
						</div>
						<div class="visible-sm">
							<div class="row">
								@if (Sentry::getUser()->hasAccess('form.read'))
									<div class="col-6">
										<p><a href="{{ URL::to('admin/formviewer/'.$form->key.'/detail/'.$e->data_id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['view'] }}</a></p>
									</div>
								@endif

								@if (Sentry::getUser()->hasAccess('form.update'))
									<div class="col-6">
										<p><a href="{{ URL::to('admin/formviewer/'.$form->key.'/update/'.$e->data_id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
									</div>
								@endif

								@if (Sentry::getUser()->hasAccess('form.delete'))
									<div class="col-12">
										<p><a href="#" class="btn btn-block btn-danger js-tab-action icn-size-16" data-action="delete" data-id="{{ $e->data_id }}">{{ $_icons['remove'] }}</a></p>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>

		{{ $entries->links() }}
	@else
		{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form entries'))]) }}
	@endif
@else
	{{ partial('common/alert', ['content' => lang('error.admin.formViewerNotAllowed'), 'class' => 'alert-danger']) }}
@endif