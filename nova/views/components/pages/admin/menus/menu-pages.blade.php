<div class="visible-xs visible-sm">
	<p><a href="{{ route('admin.menus') }}" class="btn btn-default btn-lg btn-block">Menu Manager</a></p>
</div>
<div class="visible-md visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('admin.menus') }}" class="btn btn-default">Menu Manager</a>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-3 col-md-push-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">With Selected...</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="control-label">Assign to New Menu</label>
					{!! Form::select('new_menu', [], null, ['class' => 'form-control']) !!}
				</div>

				<hr>

				<div class="visible-xs visible-sm">
					<p><a href="#" class="btn btn-default btn-lg btn-block">Remove from This Menu</a></p>
				</div>
				<div class="visible-md visible-lg">
					<p><a href="#" class="btn btn-default btn-block">Remove from This Menu</a></p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-9 col-md-pull-3">
		<div class="checkbox">
			<label>
				{!! Form::checkbox(false, false, false, ['id' => "toggleAll"]) !!}
				<span class="text-sm no-bold" id="toggleAllLabel">Select All</span>
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