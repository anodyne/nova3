@if (Sentry::getUser()->hasAccess('pages.create'))
	<div class="btn-group">
		<a href="#" class="btn btn-success icn-size-16 js-route-action" data-action="add">{{ $_icons['add'] }}</a>
	</div>
@endif

<ul class="nav nav-tabs">
	<li class="active"><a href="#pagesUser" data-toggle="tab">{{ ucwords(langConcat('user pages')) }}</a></li>
	<li><a href="#pagesCore" data-toggle="tab">{{ ucwords(langConcat('system pages')) }}</a></li>
</ul>

<div class="tab-content">
	<div id="pagesUser" class="tab-pane active">
		@if (isset($pages['user']))
			<div class="row">
				<div class="col col-lg-4">
					<input type="text" id="searchUserPages" class="input-small" placeholder="{{ ucfirst(lang('action.search')) }}">
				</div>
			</div>

			<table class="table table-striped" id="userPages">
				<thead>
					<tr>
						<th class="col col-lg-4">{{ lang('uri') }}</th>
						<th class="col col-lg-1">{{ ucfirst(lang('verb')) }}</th>
						<th class="col col-lg-5">{{ ucfirst(lang('resource')) }}</th>
						
						@if (Sentry::getUser()->hasAccess('pages.update') or Sentry::getUser()->hasAccess('pages.delete'))
							<th class="col col-lg-2"></th>
						@endif
					</tr>
				</thead>
				<tbody>
				@foreach ($pages['user'] as $page)
					<tr>
						<td class="col col-lg-4">{{ $page->uri }}</td>
						<td class="col col-lg-1">{{ strtoupper($page->verb) }}</td>
						<td class="col col-lg-5">{{ $page->resource }}</td>
						
						@if (Sentry::getUser()->hasAccess('pages.update') or Sentry::getUser()->hasAccess('pages.delete'))
							<td class="col col-lg-2">
								<div class="btn-toolbar pull-right">
									@if (Sentry::getUser()->hasAccess('pages.update'))
										<div class="btn-group">
											<a href="#" class="btn btn-default btn-small icn-size-16 js-route-action" data-route="{{ $page->id }}" data-action="edit">{{ $_icons['edit'] }}</a>
										</div>
									@endif

									@if (Sentry::getUser()->hasAccess('pages.delete'))
										<div class="btn-group">
											<a href="#" class="btn btn-danger btn-small icn-size-16 js-route-action" data-route="{{ $page->id }}" data-action="delete">{{ $_icons['remove'] }}</a>
										</div>
									@endif
								</div>
							</td>
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>
		@else
			<p class="alert">{{ lang('error.notFound', lang('pages')) }}</p>
		@endif
	</div>

	<div id="pagesCore" class="tab-pane">
		@if (isset($pages['system']))
			<div class="row">
				<div class="col col-lg-4">
					<input type="text" id="searchSystemPages" class="input-small" placeholder="{{ ucfirst(lang('action.search')) }}">
				</div>
			</div>

			<table class="table table-striped" id="systemPages">
				<thead>
					<tr>
						<th class="col col-lg-4" filter="false">{{ lang('uri') }}</th>
						<th class="col col-lg-1" filter="false">{{ ucfirst(lang('verb')) }}</th>
						<th class="col col-lg-6" filter="false">{{ ucfirst(lang('resource')) }}</th>
						
						@if (Sentry::getUser()->hasAccess('pages.create'))
							<th class="col col-lg-1" filter="false"></th>
						@endif
					</tr>
				</thead>
				<tbody>
				@foreach ($pages['system'] as $page)
					<tr>
						<td class="col col-lg-4">{{ $page->uri }}</td>
						<td class="col col-lg-1">{{ strtoupper($page->verb) }}</td>
						<td class="col col-lg-6">{{ $page->resource }}</td>
						
						@if (Sentry::getUser()->hasAccess('pages.create'))
							<td class="col col-lg-1">
								<div class="btn-group pull-right">
									<a href="#" class="btn btn-default btn-small icn-size-16 js-route-action" data-route="{{ $page->id }}" data-action="duplicate">{{ $_icons['duplicate'] }}</a>
								</div>
							</td>
						@endif
					</tr>
				@endforeach
				</tbody>
			</table>
		@else
			<p class="alert">{{ lang('error.notFound', langConcat('system pages')) }}</p>
		@endif
	</div>
</div>