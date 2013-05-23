<ul class="nav nav-tabs">
	<li class="active"><a href="#pagesUser" data-toggle="tab">User Pages</a></li>
	<li><a href="#pagesCore" data-toggle="tab">Core Pages</a></li>
</ul>

<div class="tab-content">
	<div id="pagesUser" class="active tab-pane">
		@if (isset($pages['user']))
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="col col-lg-3">URI</th>
						<th class="col col-lg-1">Verb</th>
						<th class="col col-lg-5">Resource</th>
						<th class="col col-lg-3"></th>
					</tr>
				</thead>
				<tbody>
				@foreach ($pages['user'] as $page)
					<tr>
						<td class="col col-lg-3">{{ $page->uri }}</td>
						<td class="col col-lg-1">{{ strtoupper($page->verb) }}</td>
						<td class="col col-lg-5">{{ $page->resource }}</td>
						<td class="col col-lg-3">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="#" class="btn btn-default btn-small icn-size-16">{{ $_icons['edit'] }}</a>
								</div>
								<div class="btn-group">
									<a href="#" class="btn btn-danger btn-small icn-size-16">{{ $_icons['remove'] }}</a>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@else
			<p class="alert">{{ lang('error.notFound', lang('pages')) }}</p>
		@endif
	</div>

	<div id="pagesCore" class="tab-pane">
		@if (isset($pages['core']))
			<table class="table table-striped">
				<thead>
					<tr>
						<th class="col col-lg-3">URI</th>
						<th class="col col-lg-1">Verb</th>
						<th class="col col-lg-5">Resource</th>
						<th class="col col-lg-3"></th>
					</tr>
				</thead>
				<tbody>
				@foreach ($pages['core'] as $page)
					<tr>
						<td class="col col-lg-3">{{ $page->uri }}</td>
						<td class="col col-lg-1">{{ strtoupper($page->verb) }}</td>
						<td class="col col-lg-5">{{ $page->resource }}</td>
						<td class="col col-lg-3">
							<div class="btn-group pull-right">
								<a href="#" class="btn btn-default btn-small icn-size-16">{{ $_icons['duplicate'] }}</a>
							</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@else
			<p class="alert">{{ lang('error.notFound', lang('pages')) }}</p>
		@endif
	</div>
</div>