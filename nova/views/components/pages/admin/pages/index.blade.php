<div class="btn-toolbar">
	<div class="btn-group">
		<a href="#" class="btn btn-success">Add New Page</a>
	</div>
</div>

<div class="data-table data-table-bordered data-table-striped">
@foreach ($pages as $page)
	<div class="row">
		<div class="col-md-1"><p>{!! $page->present()->verbAsLabel !!}</p></div>
		<div class="col-xs-6 col-md-8">
			<p class="lead">{!! $page->present()->name !!}</p>
			<p><code>{{ $page->present()->uri }}</code></p>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="visible-xs visible-sm"></div>
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