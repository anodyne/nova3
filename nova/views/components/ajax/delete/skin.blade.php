<p>{{ lang('short.deleteConfirm', lang('skin'), $skin->name) }}</p>

{{ Form::open(['url' => 'admin/catalog/skins']) }}
	@if (count($skins) > 0)
		<div class="row">
			<div class="col-lg-6">
				{{ Form::select('new_skin', $skins, null, ['class' => 'form-control']) }}
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="help-block">{{ lang('short.admin.catalog.deleteUpdates', lang('skin'), $skin->name) }}</p>
			</div>
		</div>
	@endif

	{{ Form::token() }}
	{{ Form::hidden('id', $skin->id) }}
	{{ Form::hidden('formAction', 'delete') }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
{{ Form:: close() }}