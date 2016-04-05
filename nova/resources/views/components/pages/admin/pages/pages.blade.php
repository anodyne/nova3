<div v-show="loading">
	<div v-if="!loadingWithError">
		<h4 class="text-center">{!! HTML::image('nova/resources/images/ajax-loader.gif') !!}</h4>
	</div>
	
	<div v-else v-cloak>
		{!! alert('danger', "There was an error retrieving your pages from the database. This can be caused by a wrong URL or an issue with the database. Please try again.", "Error!") !!}
	</div>
</div>

<div v-else v-cloak>
	<mobile>
		@can('create', $page)
			<p><a href="{{ route('admin.pages.create') }}" class="btn btn-success btn-lg btn-block">Add a Page</a></p>
		@endcan

		<p><a href="{{ route('admin.content') }}" class="btn btn-default btn-lg btn-block">Manage Page Content</a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			@can('create', $page)
				<div class="btn-group">
					<a href="{{ route('admin.pages.create') }}" class="btn btn-success">Add a Page</a>
				</div>
			@endcan

			<div class="btn-group">
				<a href="{{ route('admin.content') }}" class="btn btn-default">Manage Page Content</a>
			</div>
		</div>
	</desktop>

	<div class="row">
		<div class="col-md-3 col-md-push-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Filter Pages</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label">By Name/Key/URI</label>
						{!! Form::text('searchName', null, ['class' => 'form-control', 'v-model' => 'search']) !!}
					</div>
					
					<div class="form-group">
						<label class="control-label">By HTTP Verb</label>
						<div>
							<div class="checkbox">
								<label><input type="checkbox" value="GET" v-model="verbs"> GET</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="POST" v-model="verbs"> POST</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="PUT" v-model="verbs"> PUT</label>
							</div>
							<div class="checkbox">
								<label><input type="checkbox" value="DELETE" v-model="verbs"> DELETE</label>
							</div>
						</div>
					</div>
				</div>

				<div class="panel-footer">
					<mobile>
						<a class="btn btn-default btn-lg btn-block" @click="resetFilters">Reset Filters</a>
					</mobile>
					<desktop>
						<a class="btn btn-default btn-block" @click="resetFilters">Reset Filters</a>
					</desktop>
				</div>
			</div>
		</div>

		<div class="col-md-9 col-md-pull-3">
			<div class="data-table data-table-bordered data-table-striped">
				<div class="row" v-for="page in pages | filterBy search in 'name' 'key' 'uri' | filterByCheckboxes verbs 'verb'">
					<div class="col-md-9">
						<p class="lead"><strong>@{{ page.name }}</strong></p>
						<p><strong>Key:</strong> @{{ page.key }}</p>
						<p><strong>URI:</strong> <code>@{{ page.uri }}</code></p>
						<p><strong>Verb:</strong> <span class="label label-default">@{{ page.verb }}</span></p>
					</div>
					<div class="col-md-3">
						<mobile>
							<div class="row">
								@can('edit', $page)
									<div class="col-sm-6">
										<p><a href="@{{ page.links.edit }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
									</div>
								@endcan

								@can('remove', $page)
									<div class="col-sm-6" v-show="!page.protected">
										<p><a href="#" class="btn btn-danger btn-lg btn-block" @click.prevent="removePage(page.id)">Remove</a></p>
									</div>
								@endcan
							</div>
						</mobile>
						<desktop>
							<div class="btn-toolbar pull-right">
								@can('edit', $page)
									<div class="btn-group">
										<a href="@{{ page.links.edit }}" class="btn btn-default">Edit</a>
									</div>
								@endcan

								@can('remove', $page)
									<div class="btn-group" v-show="!page.protected">
										<a href="#" class="btn btn-danger" @click.prevent="removePage(page.id)">Remove</a>
									</div>
								@endcan
							</div>
						</desktop>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@can('remove', $page)
	{!! modal(['id' => "removePage", 'header' => "Remove Page"]) !!}
@endcan