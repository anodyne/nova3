<div ng-controller="PagesLoadingController">
	<div ng-show="loading">
		<h4 class="text-center">{!! HTML::image('nova/assets/images/ajax-loader.gif') !!}</h4>
	</div>

	<div ng-hide="loading">
		<div class="visible-xs visible-sm">
			<p><a href="{{ route('admin.pages.create') }}" class="btn btn-success btn-lg btn-block">Add a New Page</a></p>
		</div>
		<div class="visible-md visible-lg">
			<div class="btn-toolbar">
				<div class="btn-group">
					<a href="{{ route('admin.pages.create') }}" class="btn btn-success">Add a New Page</a>
				</div>
			</div>
		</div>

		<div class="row" id="pages" ng-controller="PagesController">
			<div class="col-md-3 col-md-push-9">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Filter Pages</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label">By HTTP Verb</label>
							<div id="verbCheckboxes" ng-repeat="verb in verbsGroup">
								<div class="checkbox">
									<label class="text-sm"><input type="checkbox" ng-model="useVerbs[verb]"> {% verb %}</label>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label">By Key</label>
							{!! Form::text('searchKey', null, ['class' => 'form-control', 'ng-model' => 'search.key']) !!}
						</div>

						<div class="form-group">
							<label class="control-label">By URI</label>
							{!! Form::text('searchUri', null, ['class' => 'form-control', 'ng-model' => 'search.uri']) !!}
						</div>
					</div>

					<div class="panel-footer">
						<a class="btn btn-default btn-lg btn-block" ng-click="search = {}; useVerbs = {}">Reset Filters</a>
					</div>
				</div>
			</div>

			<div class="col-md-9 col-md-pull-3">
				<div class="data-table data-table-bordered data-table-striped">
					<div class="row" ng-repeat="page in filteredPages | filter:search">
						<div class="col-md-9">
							<p>{% page.name %}</p>
							<p><strong>Key:</strong> {% page.key %}</p>
							<p><strong>URI:</strong> <code>{% page.uri %}</code></p>
							<p><strong>Verb:</strong> <span class="label label-default">{% page.verb %}</span></p>
						</div>
						<div class="col-md-3">
							<div class="visible-xs visible-sm"></div>
							<div class="visible-md visible-lg">
								<div class="btn-toolbar pull-right">
									<div class="btn-group">
										<a href="{% page.editLink %}" class="btn btn-default">Edit</a>
									</div>
									<div class="btn-group" ng-hide="{% page.protected %}">
										<a href="#" class="btn btn-danger">Delete</a>
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