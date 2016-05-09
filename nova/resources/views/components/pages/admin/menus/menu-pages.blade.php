<div class="page-header">
	<h1>Manage Pages with the {{ $menu->name }} Menu</h1>
</div>

<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.menus') }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Menus</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.menus') }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Menus</span></a>
			</div>
		</div>
	</desktop>

	{!! Form::open(['route' => ['admin.menus.pages.update', $menu->key], 'method' => 'put']) !!}
		<div class="row">
			<div class="col-md-3 col-md-push-9">
				<div v-show="checked > 0" class="panel panel-default" id="controls">
					<div class="panel-heading">
						<h3 class="panel-title">With Selected...</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label">Assign New Menu</label>
							{!! Form::select('new_menu', $menus, null, ['class' => 'form-control']) !!}
						</div>

						<mobile>
							<p>{!! Form::button("Update", ['type' => 'submit', 'class' => 'btn btn-default btn-lg btn-block']) !!}</p>
						</mobile>
						<desktop>
							<p>{!! Form::button("Update", ['type' => 'submit', 'class' => 'btn btn-default btn-block']) !!}</p>
						</desktop>
					</div>
				</div>
			</div>
			<div class="col-md-9 col-md-pull-3">
				<div class="checkbox">
					<label>
						{!! Form::checkbox('checkall', false, false, ['v-model' => 'checkAll']) !!}
						<span class="no-bold" id="toggleAllLabel">@{{ selectAllLabel }}</span>
					</label>
				</div>

				<div class="data-table data-table-striped data-table-bordered">
					<div class="row" v-for="page in pages">
						<div class="col-xs-1">
							<p><input type="checkbox" value="page.id" v-model="page.selected" id="pageCheckbox@{{ page.id }}"></p>
						</div>
						<div class="col-xs-11">
							<p><label for="pageCheckbox@{{ page.id }}">@{{ page.name }}</label></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
</div>