<div class="btn-toolbar">
	@if ($_currentUser->hasAccess('role.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/role/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif

	<div class="btn-group">
		<a href="{{ URL::to('admin/role/tasks') }}" class="btn btn-default icn-size-16 tooltip-top" title="{{ lang('Short.manage', langConcat('access role tasks')) }}">{{ $_icons['list'] }}</a>
	</div>
</div>

@if (count($roles) > 0)
	<div class="nv-data-table nv-data-table-striped nv-data-table-bordered">
		@foreach ($roles as $role)
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-lg-9">
					<p><strong>{{ $role->name }}</strong></p>
					<p class="text-muted text-small">{{ $role->desc }}</p>
				</div>
				<div class="col-xs-12 col-sm-12 col-lg-3">
					<div class="visible-lg">
						<div class="btn-toolbar pull-right">
							<div class="btn-group">
								<a href="#" class="btn btn-sm btn-default tooltip-top js-role-action icn-size-16" title="{{ lang('Short.view', langConcat('users with this role')) }}" data-action="view" data-id="{{ $role->id }}">{{ $_icons['view'] }}</a>

								@if ($_currentUser->hasAccess('role.create'))
									<a href="#" class="btn btn-sm btn-default js-role-action icn-size-16 tooltip-top" title="{{ lang('Short.duplicate', lang('role')) }}" data-action="duplicate" data-id="{{ $role->id }}">{{ $_icons['duplicate'] }}</a>
								@endif
							</div>

							<div class="btn-group">
								@if ($_currentUser->hasAccess('role.update'))
									<a href="{{ URL::to('admin/role/'.$role->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['edit'] }}</a>
								@endif
							</div>

							@if ($_currentUser->hasAccess('role.delete'))
								<div class="btn-group">
									<a href="#" class="btn btn-sm btn-danger js-role-action icn-size-16" data-action="delete" data-id="{{ $role->id }}">{{ $_icons['remove'] }}</a>
								</div>
							@endif
						</div>
					</div>
					<div class="hidden-lg">
						<div class="row">
							<div class="col-xs-12 col-sm-3">
								<p><a href="#" class="btn btn-block btn-default js-role-action icn-size-16" data-action="view" data-id="{{ $role->id }}">{{ $_icons['view'] }}</a></p>
							</div>
								
							@if ($_currentUser->hasAccess('role.update'))
								<div class="col-xs-12 col-sm-3">
									<p><a href="{{ URL::to('admin/role/'.$role->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
								</div>
							@endif

							@if ($_currentUser->hasAccess('role.create'))
								<div class="col-xs-12 col-sm-3">
									<p><a href="#" class="btn btn-block btn-default js-role-action icn-size-16"  data-action="duplicate" data-id="{{ $role->id }}">{{ $_icons['duplicate'] }}</a></p>
								</div>
							@endif

							@if ($_currentUser->hasAccess('role.delete'))
								<div class="col-xs-12 col-sm-3">
									<p><a href="#" class="btn btn-block btn-danger js-role-action icn-size-16" data-action="delete" data-id="{{ $role->id }}">{{ $_icons['remove'] }}</a></p>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@else
	{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('access roles'))]) }}
@endif