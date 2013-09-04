<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/formviewer/'.$formKey) }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

{{ Form::open(['url' => 'admin/formviewer/'.$formKey]) }}
	@if ($action == 'update' or $action == 'detail')
		<dl>
			@if ($entry->author !== null)
				<dt>{{ langConcat('Action.created By') }}</dt>
				<dd>{{ $entry->author->name }}</dd>
			@endif

			<dt>{{ lang('Action.submitted') }}</dt>
			<dd>{{ $entry->created_at }}</dd>
		</dl>
	@endif

	{{ $dynamicForm }}

	@if ($action == 'create' or $action == 'update')
		<div class="row">
			<div class="col-lg-12">
				{{ Form::token() }}
				{{ Form::hidden('id', $id) }}
				{{ Form::hidden('formAction', $action) }}
				{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
			</div>
		</div>
	@endif
{{ Form::close() }}