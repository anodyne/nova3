<div ng-controller="PermissionsLoadingController">
	<div ng-show="loading">
		<h4 class="text-center">{!! HTML::image('nova/resources/images/ajax-loader.gif') !!}</h4>
	</div>

	<div ng-cloak>
		<div class="visible-xs visible-sm">
			@if ($_user->can('access.create'))
				<p><a href="{{ route('admin.access.permissions.create') }}" class="btn btn-success btn-lg btn-block">Add a Permission</a></p>
			@endif

			<p><a href="{{ route('admin.access.roles') }}" class="btn btn-default btn-lg btn-block">Manage Access Roles</a></p>
		</div>
		<div class="visible-md visible-lg">
			<div class="btn-toolbar">
				@if ($_user->can('access.create'))
					<div class="btn-group">
						<a href="{{ route('admin.access.permissions.create') }}" class="btn btn-success">Add a Permission</a>
					</div>
				@endif

				<div class="btn-group">
					<a href="{{ route('admin.access.roles') }}" class="btn btn-default">Manage Access Roles</a>
				</div>
			</div>
		</div>

		<div class="row" id="permissions" ng-controller="PermissionsController">
			<div class="col-md-3 col-md-push-9">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Filter Permissions</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label">By Name</label>
							{!! Form::text('searchName', null, ['class' => 'form-control', 'ng-model' => 'search.display_name']) !!}
						</div>

						<div class="form-group">
							<label class="control-label">By Key</label>
							{!! Form::text('searchKey', null, ['class' => 'form-control', 'ng-model' => 'search.name']) !!}
						</div>
					</div>

					<div class="panel-footer">
						<div class="visible-xs visible-sm">
							<a class="btn btn-default btn-lg btn-block" ng-click="search = {}">Reset Filters</a>
						</div>
						<div class="visible-md visible-lg">
							<a class="btn btn-default btn-block" ng-click="search = {}">Reset Filters</a>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-9 col-md-pull-3">
				<div class="data-table data-table-bordered data-table-striped">
					<div class="row" ng-repeat="permission in permissions | toArray | filter:search">
						<div class="col-md-9">
							<p class="lead"><strong>{% permission.display_name %}</strong></p>
							<p><strong>Key:</strong> {% permission.name %}</p>
							<p ng-hide="permission.roles == ''"><strong>Included in Role(s):</strong> <span ng-bind-html="permission.roles"></span></p>
						</div>
						<div class="col-md-3">
							<div class="visible-xs visible-sm">
								<div class="row">
									@if ($_user->can('access.edit'))
										<div class="col-sm-6">
											<p><a href="{% permission.links.edit %}" class="btn btn-default btn-lg btn-block">Edit</a></p>
										</div>
									@endif

									@if ($_user->can('access.remove'))
										<div class="col-sm-6" ng-hide="permission.protected">
											<p><a href="#" data-id="{% permission.id %}" data-action="remove" class="btn btn-danger btn-lg btn-block js-permissionAction">Remove</a></p>
										</div>
									@endif
								</div>
							</div>
							<div class="visible-md visible-lg">
								<div class="btn-toolbar pull-right">
									@if ($_user->can('access.edit'))
										<div class="btn-group">
											<a href="{% permission.links.edit %}" class="btn btn-default">Edit</a>
										</div>
									@endif

									@if ($_user->can('access.remove'))
										<div class="btn-group" ng-hide="permission.protected">
											<a href="#" data-id="{% permission.id %}" data-action="remove" class="btn btn-danger js-permissionAction">Remove</a>
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@if ($_user->can('access.remove'))
	{!! modal(['id' => "removePermission", 'header' => "Remove Permission"]) !!}
@endif