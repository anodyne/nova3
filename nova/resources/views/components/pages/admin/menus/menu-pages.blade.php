<div class="page-header">
	<h1>Manage Pages with the {{ $menu->name }} Menu</h1>
</div>

<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.menus') }}" class="btn btn-default btn-lg btn-block">Menu Manager</a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.menus') }}" class="btn btn-default">Menu Manager</a>
			</div>
		</div>
	</desktop>
</div>

@if ($pages->count() > 0)
	{!! Form::open(['route' => ['admin.menus.pages.update', $menu->key], 'method' => 'put']) !!}
		<div class="row">
			<div class="col-md-3 col-md-push-9">
				<div class="panel panel-default hide" id="controls">
					<div class="panel-heading">
						<h3 class="panel-title">With Selected...</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label">Assign New Menu</label>
							{!! Form::select('new_menu', $menus, null, ['class' => 'form-control']) !!}
						</div>

						<div v-cloak>
							<mobile>
								<p>{!! Form::button("Update", ['type' => 'submit', 'class' => 'btn btn-default btn-lg btn-block']) !!}</p>
							</mobile>
							<desktop>
								<p>{!! Form::button("Update", ['type' => 'submit', 'class' => 'btn btn-default btn-block']) !!}</p>
							</desktop>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9 col-md-pull-3">
				<div class="checkbox">
					<label>
						{!! Form::checkbox('checkall', false, false, ['class' => 'js-checkAll']) !!}
						<span class="no-bold" id="toggleAllLabel">Select All</span>
					</label>
				</div>

				<div class="data-table data-table-striped data-table-bordered">
				@foreach ($pages as $page)
					<div class="row">
						<div class="col-xs-1">
							<p>{!! Form::checkbox('pages[]', $page->id, false, ['id' => "pageCheckbox{$page->id}"]) !!}</p>
						</div>
						<div class="col-xs-11">
							<p><label for="pageCheckbox{{ $page->id }}">{{ $page->present()->name }}</label></p>
						</div>
					</div>
				@endforeach
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@else
	{!! alert('warning', "This menu doesn't have any associated pages.") !!}
@endif