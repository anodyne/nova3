<p>Are you sure you want to remove the <strong>{{ $menu->present()->name }}</strong> menu? Removing this menu will re-assign any pages in the system to display the selected menu below when they're active as well as remove all menu items currently attached to this menu. This action is permanent and can't be undone!</p>

{!! Form::model($menu, ['route' => ['admin.menus.destroy', $menu->id], 'method' => 'delete']) !!}
	<div class="form-group">
		<label class="control-label">New Menu</label>
		{!! Form::select('new_menu', $menus, null, ['class' => 'form-control input-lg']) !!}
		<p class="help-block">Pages can be set to display a specific menu when they're active. Any pages set to display the <strong>{{ $menu->present()->name }}</strong> menu will be updated to display this menu instead.</p>
	</div>

	<div class="visible-xs visible-sm">
		<p>{!! Form::button("Remove Menu", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
		<p>{!! Form::button("Cancel", ['class' => 'btn btn-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
	</div>
	<div class="visible-md visible-lg">
		{!! Form::button("Remove Menu", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}
		{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg', 'data-dismiss' => 'modal']) !!}
	</div>
{!! Form::close() !!}