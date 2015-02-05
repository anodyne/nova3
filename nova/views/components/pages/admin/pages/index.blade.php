<h1>Page Manager</h1>

<div class="data-table data-table-bordered data-table-striped">
@foreach ($pages as $page)
	<div class="row">
		<div class="col-xs-6 col-md-9">
			<p>{!! $page->present()->name !!}</p>
			<p><code>{{ $page->present()->uri }}</code></p>
		</div>
		<div class="col-xs-6 col-md-3">
			<div class="visible-xs visible-sm"></div>
			<div class="visible-md visible-lg">
				<div class="btn-toolbar pull-right">
					<div class="btn-group">
						<a href="{{ url('admin/pages/'.$page->id.'/edit') }}" class="btn btn-default btn-sm">Edit</a>
					</div>

					@if ( ! $page->protected)
						<div class="btn-group">
							<a href="#" class="btn btn-danger btn-sm">Delete</a>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endforeach
</div>