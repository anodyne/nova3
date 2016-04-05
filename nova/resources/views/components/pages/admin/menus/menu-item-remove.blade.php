<p>Are you sure you want to remove the <strong>{{ $item->present()->title }}</strong> menu item? This action is permanent and can't be undone!</p>

{!! Form::model($item, ['route' => ['admin.menus.items.destroy', $item->id], 'method' => 'delete']) !!}
	<div v-cloak>
		<mobile>
			<p>{!! Form::button("Remove Menu Item", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
			<p>{!! Form::button("Cancel", ['class' => 'btn btn-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
		</mobile>
		<desktop>
			{!! Form::button("Remove Menu Item", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}
			{!! Form::button("Cancel", ['class' => 'btn btn-link-default', 'data-dismiss' => 'modal']) !!}
		</desktop>
	</div>
{!! Form::close() !!}