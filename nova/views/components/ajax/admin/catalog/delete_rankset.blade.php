<p>{{ lang('short.deleteConfirm', lang('rank_set'), $rank->name) }}</p>

{{ Form::open(['url' => 'admin/catalog/ranks']) }}
	@if (count($ranks) > 0)
		<div class="row">
			<div class="col-lg-6">
				{{ Form::select('new_rank_set', $ranks) }}
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<p class="help-block">{{ lang('short.admin.catalog.deleteUpdates', lang('rank_set'), $rank->name) }}</p>
			</div>
		</div>
	@endif

	{{ Form::token() }}
	{{ Form::hidden('id', $rank->id) }}
	{{ Form::hidden('formAction', 'delete') }}
	{{ Form::button(lang('Action.delete'), ['type' => 'submit', 'class' => 'btn btn-danger']) }}
{{ Form:: close() }}