<p>Are you sure you want to remove the <strong>{{ $page->present()->name }}</strong> page? This action is permanent and can't be undone!</p>

{!! Form::model($page, ['route' => ['admin.pages.destroy', $page->id], 'method' => 'delete']) !!}
	<div class="visible-xs visible-sm">
		<p>{!! Form::button("Remove", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
	</div>
	<div class="visible-md visible-lg">
		<p>{!! Form::button("Remove", ['type' => 'submit', 'class' => 'btn btn-danger']) !!}</p>
	</div>
{!! Form::close() !!}