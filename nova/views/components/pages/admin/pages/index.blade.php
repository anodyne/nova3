<div class="row">
	<div class="col-md-3 col-md-push-9">
		<h3>Filter Pages</h3>
		<hr>

		<div class="form-group">
			<label class="control-label">By HTTP Verb</label>
			{!! Form::select('verb', ['' => '', 'GET' => 'GET', 'POST' => 'POST', 'PUT' => 'PUT', 'DELETE' => 'DELETE'], null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			<label class="control-label">By Key</label>
			{!! Form::text('key', null, ['class' => 'form-control']) !!}
		</div>

		<div class="form-group">
			<label class="control-label">By URI</label>
			{!! Form::text('uri', null, ['class' => 'form-control']) !!}
		</div>
	</div>

	<div class="col-md-9 col-md-pull-3">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.pages.create') }}" class="btn btn-success">Add a New Page</a>
			</div>
		</div>

		<div class="data-table data-table-bordered data-table-striped">
		@foreach ($pages as $page)
			<div class="row">
				<div class="col-sm-2 col-md-1"><p>{!! $page->present()->verbAsLabel !!}</p></div>
				<div class="col-sm-10 col-md-8">
					<p>{!! $page->present()->name !!}</p>
					<p><code>{{ $page->present()->uri }}</code></p>
				</div>
				<div class="col-xs-12 col-md-3">
					<div class="visible-xs visible-sm">
						@if ($page->verb == 'GET' and ! Str::contains($page->uri, '{'))
							<p><a href="{{ route($page->key) }}" class="btn btn-default btn-lg btn-block">View</a></p>
						@endif
						<p><a href="{{ route('admin.pages.edit', [$page->id]) }}" class="btn btn-default btn-lg btn-block">Edit</a></p>

						@if ( ! $page->protected)
							<p><a href="#" class="btn btn-danger btn-lg btn-block">Delete</a></p>
						@endif
					</div>
					<div class="visible-md visible-lg">
						<div class="btn-toolbar pull-right">
							@if ($page->verb == 'GET' and ! Str::contains($page->uri, '{'))
								<div class="btn-group">
									<a href="{{ route($page->key) }}" class="btn btn-default">View</a>
								</div>
							@endif
							<div class="btn-group">
								<a href="{{ route('admin.pages.edit', [$page->id]) }}" class="btn btn-default">Edit</a>
							</div>

							@if ( ! $page->protected)
								<div class="btn-group">
									<a href="#" class="btn btn-danger">Delete</a>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		@endforeach
		</div>
	</div>
</div>