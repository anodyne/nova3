<div ng-controller="PageContentsLoadingController">
	<div ng-show="loading">
		<h4 class="text-center">{!! HTML::image('nova/resources/images/ajax-loader.gif') !!}</h4>
	</div>

	<div ng-cloak>
		<div class="visible-xs visible-sm">
			@if ($_user->can('page.create'))
				<p><a href="{{ route('admin.content.create') }}" class="btn btn-success btn-lg btn-block">Add Page Content</a></p>
			@endif

			<p><a href="{{ route('admin.pages') }}" class="btn btn-default btn-lg btn-block">Pages</a></p>
		</div>
		<div class="visible-md visible-lg">
			<div class="btn-toolbar">
				@if ($_user->can('page.create'))
					<div class="btn-group">
						<a href="{{ route('admin.content.create') }}" class="btn btn-success">Add Page Content</a>
					</div>
				@endif

				<div class="btn-group">
					<a href="{{ route('admin.pages') }}" class="btn btn-default">Pages</a>
				</div>
			</div>
		</div>

		<div id="pages" ng-controller="PageContentsController">
			<div class="row">
				<div class="col-md-3 col-md-push-9">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Filter Page Content</h3>
						</div>
						<div class="panel-body">
							<div class="form-group">
								<label class="control-label">By Type</label>
								<div id="typeCheckboxes" ng-repeat="type in typesGroup">
									<div class="checkbox">
										<label><input type="checkbox" ng-model="useTypes[type]"> {% type %}</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label">By Key</label>
								{!! Form::text('searchKey', null, ['class' => 'form-control', 'ng-model' => 'search.key']) !!}
							</div>

							<div class="form-group">
								<label class="control-label">By Value</label>
								{!! Form::text('searchValue', null, ['class' => 'form-control', 'ng-model' => 'search.value']) !!}
							</div>
						</div>

						<div class="panel-footer">
							<div class="visible-xs visible-sm">
								<a class="btn btn-default btn-lg btn-block" ng-click="search = {}; useTypes = {}">Reset Filters</a>
							</div>
							<div class="visible-md visible-lg">
								<a class="btn btn-default btn-block" ng-click="search = {}; useTypes = {}">Reset Filters</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-9 col-md-pull-3" ng-show="filteredContents.length == 0">
					{!! alert('warning', "No additional page content found.") !!}
				</div>

				<div class="col-md-9 col-md-pull-3" ng-show="filteredContents.length > 0">
					<div class="data-table data-table-bordered data-table-striped">
						<div class="row" ng-repeat="content in filteredContents | filter:search">
							<div class="col-md-9">
								<p>{% content.preview %}</p>
								<p><strong>Key:</strong> {% content.key %}</p>
								<p><strong>Type:</strong> <span class="label label-default">{% content.type %}</span></p>
							</div>
							<div class="col-md-3">
								<div class="visible-xs visible-sm">
									<div class="row">
										@if ($_user->can('page.edit'))
											<div class="col-sm-6">
												<p><a href="{% content.links.edit %}" class="btn btn-default btn-lg btn-block">Edit</a></p>
											</div>
										@endif

										@if ($_user->can('page.remove'))
											<div class="col-sm-6" ng-hide="content.protected">
												<p><a href="#" data-id="{% content.id %}" data-action="remove" class="btn btn-danger btn-lg btn-block js-contentAction">Remove</a></p>
											</div>
										@endif
									</div>
								</div>
								<div class="visible-md visible-lg">
									<div class="btn-toolbar pull-right">
										@if ($_user->can('page.edit'))
											<div class="btn-group">
												<a href="{% content.links.edit %}" class="btn btn-default">Edit</a>
											</div>
										@endif

										@if ($_user->can('page.remove'))
											<div class="btn-group" ng-hide="content.protected">
												<a href="#" data-id="{% content.id %}" data-action="remove" class="btn btn-danger js-contentAction">Remove</a>
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
</div>

@if ($_user->can('page.remove'))
	{!! modal(['id' => "removeContent", 'header' => "Remove Page Content"]) !!}
@endif