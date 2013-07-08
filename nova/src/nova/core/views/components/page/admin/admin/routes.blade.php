@if (Sentry::getUser()->hasAccess('routes.create'))
	<div class="visible-lg">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="#" class="btn btn-success icn-size-16 js-route-action" data-action="add">{{ $_icons['add'] }}</a>
			</div>
		</div>
	</div>
	<div class="hidden-lg">
		<div class="row">
			<div class="col-4">
				<p><a href="#" class="btn btn-block btn-success icn-size-16 js-route-action" data-action="add">{{ $_icons['add'] }}</a></p>
			</div>
		</div>
	</div>
@endif

<div class="hidden-sm">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#routesUser" data-toggle="tab">{{ langConcat('User_created Routes') }}</a></li>
		<li><a href="#routesCore" data-toggle="tab">{{ langConcat('Core Routes') }}</a></li>
	</ul>
</div>
<div class="visible-sm">
	<ul class="nav nav-pills">
		<li class="active"><a href="#routesUser" data-toggle="tab">{{ langConcat('User_created Routes') }}</a></li>
		<li><a href="#routesCore" data-toggle="tab">{{ langConcat('Core Routes') }}</a></li>
	</ul>
</div>

<div class="tab-content">
	<div id="routesUser" class="tab-pane active">
		@if (isset($routes['user']))
			<div class="visible-lg">
				<input type="text" id="searchUserRoutes" class="input-small col-alt-4" placeholder="{{ lang('Short.search', langConcat('User_created Routes')) }}">

				<table class="table table-striped" id="userRoutes">
					<thead>
						<tr>
							<th class="col-alt-4">{{ lang('uri') }}</th>
							<th class="col-alt-1">{{ lang('Verb') }}</th>
							<th class="col-alt-5">{{ lang('Resource') }}</th>
							<th class="col-alt-2"></th>
						</tr>
					</thead>
					<tbody>
					@foreach ($routes['user'] as $route)
						<tr>
							<td class="col-alt-4">{{ $route->uri }}</td>
							<td class="col-alt-1">{{ strtoupper($route->verb) }}</td>
							<td class="col-alt-5">{{ $route->resource }}</td>
							<td class="col-alt-2">
								<div class="btn-toolbar pull-right">
									@if (Sentry::getUser()->hasAccess('routes.update'))
										<div class="btn-group">
											<a href="#" class="btn btn-default btn-small icn-size-16 js-route-action" data-route="{{ $route->id }}" data-action="edit">{{ $_icons['edit'] }}</a>
										</div>
									@endif

									@if (Sentry::getUser()->hasAccess('routes.delete'))
										<div class="btn-group">
											<a href="#" class="btn btn-danger btn-small icn-size-16 js-route-action" data-route="{{ $route->id }}" data-action="delete">{{ $_icons['remove'] }}</a>
										</div>
									@endif
								</div>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			<div class="hidden-lg">
				<div class="row">
				@foreach ($routes['user'] as $route)
					<div class="col-12">
						<div class="thumbnail">
							<p><strong>{{ $route->uri }}</strong></p>
							<p class="text-muted text-small">{{ strtoupper($route->verb) }}</p>
							<p class="text-muted text-small">{{ $route->resource }}</p>

							@if (Sentry::getUser()->hasAccess('routes.create'))
								<div class="row">
									<div class="col-12">
										<p><a href="#" class="btn btn-block btn-default icn-size-16 js-route-action" data-route="{{ $route->id }}" data-action="duplicate">{{ $_icons['duplicate'] }}</a></p>
									</div>
								</div>
							@endif
						</div>
					</div>
				@endforeach
				</div>
			</div>
		@else
			{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('user_created routes'))]) }}
		@endif
	</div>

	<div id="routesCore" class="tab-pane">
		@if (isset($routes['core']))
			<div class="visible-lg">
				<input type="text" id="searchCoreRoutes" class="input-small col-alt-4" placeholder="{{ lang('Short.search', langConcat('Core Routes')) }}">

				<table class="table table-striped" id="coreRoutes">
					<thead>
						<tr>
							<th class="col-alt-4">{{ lang('uri') }}</th>
							<th class="col-alt-1">{{ lang('Verb') }}</th>
							<th class="col-alt-6">{{ lang('Resource') }}</th>
							<th class="col-alt-1"></th>
						</tr>
					</thead>
					<tbody>
					@foreach ($routes['core'] as $route)
						<tr>
							<td class="col-alt-4">{{ $route->uri }}</td>
							<td class="col-alt-1">{{ strtoupper($route->verb) }}</td>
							<td class="col-alt-6">{{ $route->resource }}</td>
							<td class="col-alt-1">
								@if (Sentry::getUser()->hasAccess('routes.create'))
									<div class="btn-group pull-right">
										<a href="#" class="btn btn-default btn-small icn-size-16 js-route-action" data-route="{{ $route->id }}" data-action="duplicate">{{ $_icons['duplicate'] }}</a>
									</div>
								@endif
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
			<div class="hidden-lg">
				<div class="row">
				@foreach ($routes['core'] as $route)
					<div class="col-12">
						<div class="thumbnail">
							<p><strong>{{ $route->uri }}</strong></p>
							<p class="text-muted text-small">{{ strtoupper($route->verb) }}</p>
							<p class="text-muted text-small">{{ $route->resource }}</p>

							@if (Sentry::getUser()->hasAccess('routes.create'))
								<div class="row">
									<div class="col-12">
										<p><a href="#" class="btn btn-block btn-default icn-size-16 js-route-action" data-route="{{ $route->id }}" data-action="duplicate">{{ $_icons['duplicate'] }}</a></p>
									</div>
								</div>
							@endif
						</div>
					</div>
				@endforeach
				</div>
			</div>
		@else
			{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('core routes'))]) }}
		@endif
	</div>
</div>