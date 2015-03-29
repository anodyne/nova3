<p>Are you sure you want to remove the <strong>{{ $menu->present()->name }}</strong> menu? This action is permanent and can't be undone!</p>

{!! Form::model($menu, ['route' => ['admin.menus.destroy', $menu->id], 'method' => 'delete']) !!}
	<div class="form-group">
		<label class="control-label">New Menu</label>
		{!! Form::select('new_menu', $menus, null, ['class' => 'form-control input-lg']) !!}
		<p class="help-block">Pages can be set to display a specific menu when they're active. Any pages set to display the <strong>{{ $menu->present()->name }}</strong> menu will be updated to display this menu instead.</p>
	</div>

	<div class="visible-xs visible-sm">
		<p>{!! Form::button("Remove", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
	</div>
	<div class="visible-md visible-lg">
		<p>{!! Form::button("Remove", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}</p>
	</div>
{!! Form::close() !!}