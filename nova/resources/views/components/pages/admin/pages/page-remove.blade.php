<div class="modal-body">
	<p>{!! _m('phrase-remove-confirm', [$page->present()->name, _m('page', [1])]) !!}</p>
</div>

<div class="modal-footer">
	{!! Form::model($page, ['route' => ['admin.pages.destroy', $page->id], 'method' => 'delete']) !!}
		<button type="button" class="btn btn-cancel" data-dismiss="modal">{{ _m('cancel') }}</button>
		{!! Form::button(_m('remove'), ['type' => 'submit', 'class' => 'btn btn-danger']) !!}
	{!! Form::close() !!}
</div>