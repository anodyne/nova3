<p>{{ lang('short.deleteConfirm', langConcat('site content item'), $sitecontent->label) }}</p>

{{ Form::model($sitecontent, ['url' => 'admin/sitecontent']) }}
	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('formAction', 'delete') }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
{{ Form::close() }}