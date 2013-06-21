<div class="btn-group">
	<a href="{{ URL::to('admin/form/tabs/'.$formKey) }}" class="btn btn-default icn-size-16 tooltip-top" title="{{ lang('Short.back', lang('tabs')) }}">{{ $_icons['back'] }}</a>
</div>

{{ Form::model($tab, ['url' => 'admin/form/tabs/'.$formKey]) }}
	<div class="row">
		<div class="col col-lg-4">
			<div class="control-group">
				<label class="control-label">{{ lang('Name') }}</label>
				<div class="controls">
					{{ Form::text('name') }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-2">
			<div class="control-group">
				<label class="control-label">
					{{ lang('Order') }}
					<span class="tooltip-top icn-size-16 text-muted" title="{{ lang('short.admin.forms.order') }}">{{ $_icons['question'] }}</span>
				</label>
				<div class="controls">
					{{ Form::text('order') }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-2">
			<div class="control-group">
				<label class="control-label">
					{{ langConcat('Link id') }}
					<span class="tooltip-top icn-size-16 text-muted" title="{{ lang('short.admin.forms.tabLinkId') }}">{{ $_icons['question'] }}</span>
				</label>
				<div class="controls">
					{{ Form::text('link_id') }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col col-lg-2">
			<div class="control-group">
				<label class="control-label">{{ lang('Display') }}</label>
				<div class="controls">
					<label class="radio-inline">{{ Form::radio('status', Status::ACTIVE) }} {{ lang('Yes') }}</label>
					<label class="radio-inline">{{ Form::radio('status', Status::INACTIVE) }} {{ lang('No') }}</label>
				</div>
			</div>
		</div>
	</div>

	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', $action) }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
{{ Form::close() }}