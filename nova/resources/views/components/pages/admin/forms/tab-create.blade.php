<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.forms.tabs', [$form->key]) }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Form Tabs</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.forms.tabs', [$form->key]) }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Form Tabs</span></a>
			</div>
		</div>
	</desktop>

	{!! Form::open(['route' => ['admin.forms.tabs.store', $form->key], 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Name</label>
			<div class="col-md-5">
				{!! Form::text('name', null, ['class' => 'form-control input-lg', 'v-model' => 'name', '@change' => 'updateName']) !!}
				{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Parent Tab</label>
			<div class="col-md-4">
				{!! Form::select('parent_id', $parentTabs, null, ['class' => 'form-control input-lg', 'v-model' => 'parentTab']) !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('link_id')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Link ID</label>
			<div class="col-md-5">
				{!! Form::text('link_id', null, ['class' => 'form-control input-lg', 'v-model' => 'link', '@change' => 'updateLink']) !!}
				{!! $errors->first('link_id', '<p class="help-block">:message</p>') !!}
				<p class="help-block">The link ID is necessary for creating the clickable tab that shows the tab content when clicked. The link ID must be unique to this form.</p>
			</div>
		</div>

		<div class="form-group{{ ($errors->has('status')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Status</label>
			<div class="col-md-5">
				<div>
					<div class="radio">
						<label>{!! Form::radio('status', Status::ACTIVE, true, ['v-model' => 'status']) !!} {{ ucwords(Status::toString(Status::ACTIVE)) }}</label>
					</div>
					<div class="radio">
						<label>{!! Form::radio('status', Status::INACTIVE, false, ['v-model' => 'status']) !!} {{ ucwords(Status::toString(Status::INACTIVE)) }}</label>
					</div>
				</div>
				{!! $errors->first('status', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Message</label>
			<div class="col-md-8">
				{!! Form::textarea('message', null, ['class' => 'form-control input-lg', 'rows' => 4, 'v-model' => 'message']) !!}
			</div>
		</div>

		{!! Form::hidden('form_id', $form->id) !!}
		{!! Form::hidden('formKey', $form->key, ['v-model' => 'formKey']) !!}

		<div class="form-group">
			<div class="col-md-5 col-md-offset-2">
				<mobile>
					<p>{!! Form::button("Add Tab", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
				</mobile>
				<desktop>
					<div class="btn-toolbar">
						<div class="btn-group">
							{!! Form::button("Add Tab", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
						</div>
					</div>
				</desktop>
			</div>
		</div>
	{!! Form::close() !!}
</div>