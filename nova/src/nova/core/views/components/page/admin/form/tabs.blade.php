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
	<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="sortableTabs">
		@foreach ($tabs as $t)
			<div class="row" id="tab_{{ $t->id }}">
				<div class="col-12 col-sm-8 col-lg-9">
					<p>
						<strong>{{ $t->name }}</strong>
						@if ($t->status === Status::INACTIVE)
							<span class="label label-danger">{{ lang('Inactive') }}</span>
						@endif
					</p>
				</div>
				<div class="col-12 col-sm-4 col-lg-3">
					<div class="hidden-sm">
						<div class="btn-toolbar pull-right">
							@if (Sentry::getUser()->hasAccess('form.update'))
								<div class="btn-group">
									<a href="{{ URL::to('admin/form/tabs/'.$formKey.'/'.$t->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
								</div>
							@endif

							@if (Sentry::getUser()->hasAccess('form.delete'))
								<div class="btn-group">
									<a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-small btn-danger js-tab-action icn-size-16" data-action="delete" data-id="{{ $t->id }}">{{ $_icons['remove'] }}</a>
								</div>
							@endif
						</div>
					</div>
					<div class="visible-sm">
						<div class="row">
							@if (Sentry::getUser()->hasAccess('form.update'))
								<div class="col-6">
									<p><a href="{{ URL::to('admin/form/tabs/'.$formKey.'/'.$t->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
								</div>
							@endif

							@if (Sentry::getUser()->hasAccess('form.delete'))
								<div class="col-6">
									<p><a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-block btn-danger js-tab-action icn-size-16" data-action="delete" data-id="{{ $t->id }}">{{ $_icons['remove'] }}</a></p>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@else
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('form tabs'))]) }}
@endif