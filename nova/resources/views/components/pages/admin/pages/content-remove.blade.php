<p>Are you sure you want to remove this {{ $content->present()->type }}? This action is permanent and can't be undone!</p>

<div class="well well-sm">
	<p>{!! $content->present()->value !!}</p>
</div>

{!! Form::model($content, ['route' => ['admin.content.destroy', $content->id], 'method' => 'delete']) !!}
	<div v-cloak>
		<mobile>
			<p>{!! Form::button("Remove", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
		</mobile>
		<desktop>
			<p>{!! Form::button("Remove", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}</p>
		</desktop>
	</div>
{!! Form::close() !!}