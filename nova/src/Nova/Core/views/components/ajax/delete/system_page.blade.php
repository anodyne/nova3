<p>{{ lang('short.admin.pages.removeConfirm', langConcat('system page'), $page->name) }}</p>

{{ Form::model($page, ['url' => 'admin/main/pages']) }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', 'delete') }}
	{{ Form::button(ucfirst(lang('action.submit')), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}