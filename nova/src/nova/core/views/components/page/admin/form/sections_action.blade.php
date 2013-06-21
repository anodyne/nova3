<div class="btn-group">
	<a href="{{ URL::to('admin/form/sections/'.$formKey) }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
</div>

{{ Form::model($section, ['url' => 'admin/form/sections/'.$formKey]) }}
	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<div class="control-group">
				<label class="control-label">{{ lang('Name') }}</label>
				<div class="controls">
					{{ Form::text('name') }}
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-lg-4">
			<label class="control-label">{{ lang('Order') }}</label>
			<div class="controls">
				{{ Form::text('order') }}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<p class="help-block"><?php echo lang('short.admin.forms.order');?></p>
		</div>
	</div>

	@if (count($tabs) > 0)
		<div class="row">
			<div class="col-sm-6 col-lg-4">
				<div class="control-group">
					<label class="control-label">{{ lang('Tab') }}</label>
					<div class="controls">
						{{ Form::select('tab_id', $tabs) }}
					</div>
				</div>
			</div>
		</div>
	@else
		{{ Form::hidden('tab_id', 0) }}
	@endif

	{{ Form::token() }}
	{{ Form::hidden('id') }}
	{{ Form::hidden('action', $action) }}
	{{ Form::button(lang('Action.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
</form>