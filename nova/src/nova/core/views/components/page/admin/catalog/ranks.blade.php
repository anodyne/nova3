<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/catalog') }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>

	@if (Sentry::getUser()->hasAccess('catalog.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/catalog/ranks/0') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif
</div>

@if (count($pending) > 0 and Sentry::getUser()->hasAccess('catalog.create'))
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">{{ ucwords(langConcat('pending rank_sets')) }}</h3>
		</div>

		<p>{{ lang('short.admin.catalog.ranks.pending', '<span class="icn-size-16 text-success">'.$_icons['add'].'</span>') }}</p>

		<div class="nv-data-table nv-data-table-striped nv-data-table-bordered">
			@foreach ($pending as $dir => $info)
				<div class="row">
					<div class="col-12 col-sm-6 col-lg-5">
						<p><strong>{{ $info->name }}</strong></p>
						<p class="text-small">{{ $dir }}</p>
					</div>
					<div class="col-12 col-sm-3 col-lg-5">
						<p>{{ HTML::image($rankPath.$dir.'/'.$info->preview) }}</p>
					</div>
					<div class="col-12 col-sm-3 col-lg-2">
						<div class="hidden-sm">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="#" class="btn btn-small btn-success icn-size-16 js-rank-action" data-location="{{ $dir }}" data-action="install">{{ $_icons['add'] }}</a>
								</div>
							</div>
						</div>
						<div class="visible-sm">
							<div class="row">
								<div class="col-12">
									<p><a href="#" class="btn btn-block btn-success icn-size-16 js-rank-action" data-location="{{ $dir }}" data-action="install">{{ $_icons['add'] }}</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endif

@if ($ranks->count() > 0)
	<div class="nv-data-table nv-data-table-striped nv-data-table-bordered">
		@foreach ($ranks as $rank)
			<div class="row">
				<div class="col-12 col-sm-6 col-lg-5">
					<p><strong>{{ $rank->name }}</strong></p>
					<p class="text-small">{{ $rank->location }}</p>
				</div>
				<div class="col-12 col-sm-3 col-lg-5">
					<p>{{ HTML::image($rankPath.$rank->location.'/preview'.$rank->extension) }}</p>
				</div>
				<div class="col-12 col-sm-3 col-lg-2">
					<div class="hidden-sm">
						<div class="btn-toolbar pull-right">
							@if (Sentry::getUser()->hasAccess('catalog.update'))
								<div class="btn-group">
									<a href="{{ URL::to('admin/catalog/ranks/'.$rank->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
								</div>
							@endif

							@if (Sentry::getUser()->hasAccess('catalog.delete'))
								<div class="btn-group">
									<a href="#" class="btn btn-small btn-danger icn-size-16 js-rank-action" data-id="{{ $rank->id }}" data-action="delete">{{ $_icons['remove'] }}</a>
								</div>
							@endif
						</div>
					</div>
					<div class="visible-sm">
						<div class="row">
							@if (Sentry::getUser()->hasAccess('catalog.update'))
								<div class="col-6">
									<p><a href="{{ URL::to('admin/catalog/ranks/'.$rank->id) }}" class="btn btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
								</div>
							@endif

							@if (Sentry::getUser()->hasAccess('catalog.delete'))
								<div class="col-6">
									<p><a href="#" class="btn btn-block btn-danger icn-size-16 js-rank-action" data-id="{{ $rank->id }}" data-action="delete">{{ $_icons['remove'] }}</a></p>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@else
	{{ partial('common/alert', ['content' => lang('error.notFound', lang('rank_sets'))]) }}
@endif