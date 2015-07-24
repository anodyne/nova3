<p>Are you sure you want to remove the <strong>{{ $item->present()->title }}</strong> menu item? This action is permanent and can't be undone!</p>

{!! Form::model($item, ['route' => ['admin.menus.items.destroy', $item->id], 'method' => 'delete']) !!}
	<div class="visible-xs visible-sm">
		<p>{!! Form::button("Remove", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
	</div>
	<div class="visible-md visible-lg">
		<p>{!! Form::button("Remove", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}</p>
	</div>
{!! Form::close() !!}