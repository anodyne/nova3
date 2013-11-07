<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/navigation/create') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
	</div>
</div>

<ul class="nav nav-tabs">
	@foreach ($contentTypes as $key => $type)
		<li><a href="#{{ $key }}" data-toggle="tab">{{ $type }}</a></li>
	@endforeach
</ul>

<div class="tab-content">
	@foreach ($contentTypes as $key => $type)
		<div id="{{ $key }}" class="tab-pane">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-lg-4">
					<div class="form-group">
						{{ Form::text('', null, ['id' => 'search'.$type, 'placeholder' => lang('Action.search')." ".$type, 'class' => 'form-control quicksearch-control']) }}
					</div>
				</div>
			</div>

			<div class="nv-data-table nv-data-table-striped nv-data-table-bordered" id="{{ strtolower($key) }}Search">
			@foreach ($content[$key] as $item)
				<div class="row">
					<div class="col-xs-12 col-sm-10 col-lg-8">
						<p><strong>{{ $item->label }}</strong></p>
						<p class="text-muted text-small">{{ $item->key }}</p>
					</div>
					<div class="col-xs-12 col-sm-2 col-lg-4">
						<div class="visible-lg">
							<div class="btn-toolbar pull-right">
								<div class="btn-group">
									<a href="{{ URL::to('admin/navigation/'.$item->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['edit'] }}</a>
								</div>
								@if ( ! (bool) $item->protected)
									<div class="btn-group">
										<a href="#" class="btn btn-sm btn-danger icn-size-16 js-navigation-action" data-action="delete" data-id="{{ $item->id }}">{{ $_icons['remove'] }}</a>
									</div>
								@endif
							</div>
						</div>
						<div class="hidden-lg">
							<div class="row">
								<div class="col-xs-12">
									<p><a href="{{ URL::to('admin/navigation/'.$item->id) }}" class="btn btn-lg btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
								</div>
								@if ( ! (bool) $item->protected)
									<div class="col-xs-12">
										<p><a href="#" class="btn btn-lg btn-block btn-danger icn-size-16 js-navigation-action" data-action="delete" data-id="{{ $item->id }}">{{ $_icons['remove'] }}</a></p>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			@endforeach
			</div>
		</div>
	@endforeach
</div>