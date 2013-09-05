<p>{{ lang('short.deleteConfirm', lang('entry'), $name) }}</p>

{{ Form::open(['url' => 'admin/formviewer/'.$formKey]) }}
	{{ Form::token() }}
	{{ Form::hidden('id', $id) }}
	{{ Form::hidden('formAction', 'delete') }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
{{ Form::close() }}