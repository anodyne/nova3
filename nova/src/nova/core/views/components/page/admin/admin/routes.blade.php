@if (Sentry::getUser()->hasAccess('routes.create'))
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ URL::to('admin/routes/create') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	</div>
@endif

<ul class="nav nav-tabs">
	<li class="active"><a href="#routesUser" data-toggle="tab">{{ langConcat('User_created Routes') }}</a></li>
	<li><a href="#routesCore" data-toggle="tab">{{ langConcat('Core Routes') }}</a></li>
</ul>

<div class="tab-content">
	<div id="routesUser" class="tab-pane active">
		@if (isset($routes['user']))
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-lg-4">
					<div class="form-group">
						{{ Form::text('', null, ['id' => 'searchUserRoutes', 'placeholder' => lang('Short.search', langConcat('User_created Routes')), 'class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="userRoutes">
			@foreach ($routes['user'] as $route)
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-lg-10">
						<p><strong>{{ $route->uri }}</strong></p>
						<p class="text-small">{{ Str::upper($route->verb) }}</p>
						<p class="text-small">{{ $route->resource }}</p>
					</div>
					<div class="col-xs-12 col-sm-12 col-lg-2">
						<div class="visible-lg">
							<div class="btn-toolbar pull-right">
								@if (Sentry::getUser()->hasAccess('routes.update'))
									<div class="btn-group">
										<a href="{{ URL::to('admin/routes/'.$route->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['edit'] }}</a>
									</div>
								@endif

								@if (Sentry::getUser()->hasAccess('routes.delete'))
									<div class="btn-group">
										<a href="#" class="btn btn-sm btn-danger icn-size-16 js-route-action" data-route="{{ $route->id }}" data-action="delete">{{ $_icons['remove'] }}</a>
									</div>
								@endif
							</div>
						</div>
						<div class="hidden-lg">
							<div class="row">
								<div class="col-xs-12 col-sm-6">
									@if (Sentry::getUser()->hasAccess('routes.update'))
										<p><a href="{{ URL::to('admin/routes/'.$route->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
									@endif
								</div>

								<div class="col-xs-12 col-sm-6">
									@if (Sentry::getUser()->hasAccess('routes.delete'))
										<p><a href="#" class="btn btn-block btn-danger icn-size-16 js-route-action" data-route="{{ $route->id }}" data-action="delete">{{ $_icons['remove'] }}</a></p>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
			</div>
		@else
			{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('user_created routes'))]) }}
		@endif
	</div>

	<div id="routesCore" class="tab-pane">
		@if (isset($routes['core']))
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-lg-4">
					<div class="form-group">
						{{ Form::text('', null, ['id' => 'searchCoreRoutes', 'placeholder' => lang('Short.search', langConcat('Core Routes')), 'class' => 'form-control']) }}
					</div>
				</div>
			</div>

			<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="coreRoutes">
			@foreach ($routes['core'] as $route)
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-lg-11">
						<p><strong>{{ $route->uri }}</strong></p>
						<p class="text-small">{{ Str::upper($route->verb) }}</p>
						<p class="text-small">{{ $route->resource }}</p>
					</div>
					<div class="col-xs-12 col-sm-12 col-lg-1">
						@if (Sentry::getUser()->hasAccess('routes.create'))
							<div class="btn-group pull-right visible-lg">
								<a href="#" class="btn btn-default icn-size-16 js-route-action" data-route="{{ $route->id }}" data-action="duplicate">{{ $_icons['duplicate'] }}</a>
							</div>
							<p class="hidden-lg">
								<a href="#" class="btn btn-block btn-default icn-size-16 js-route-action" data-route="{{ $route->id }}" data-action="duplicate">{{ $_icons['duplicate'] }}</a>
							</p>
						@endif
					</div>
				</div>
			@endforeach
			</div>
		@else
			{{ partial('common/alert', ['content' => lang('error.notFound', langConcat('core routes'))]) }}
		@endif
	</div>
</div>