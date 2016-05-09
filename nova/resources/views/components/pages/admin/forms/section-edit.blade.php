<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.forms.sections', [$form->key]) }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Form Sections</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.forms.sections', [$form->key]) }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Form Sections</span></a>
			</div>
		</div>
	</desktop>

	{!! Form::model($section, ['route' => ['admin.forms.sections.update', $form->key, $section->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Name</label>
			<div class="col-md-5">
				{!! Form::text('name', null, ['class' => 'form-control input-lg', 'v-model' => 'name']) !!}
				{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Parent Tab</label>
			<div class="col-md-4">
				{!! Form::select('tab_id', $tabs, null, ['class' => 'form-control input-lg', 'v-model' => 'tabId']) !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('status')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Status</label>
			<div class="col-md-5">
				<div>
					<div class="radio">
						<label>{!! Form::radio('status', Status::ACTIVE, null, ['v-model' => 'status']) !!} {{ ucwords(Status::toString(Status::ACTIVE)) }}</label>
					</div>
					<div class="radio">
						<label>{!! Form::radio('status', Status::INACTIVE, null, ['v-model' => 'status']) !!} {{ ucwords(Status::toString(Status::INACTIVE)) }}</label>
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

		<div class="form-group">
			<div class="col-md-5 col-md-offset-2">
				<mobile>
					<p>{!! Form::button("Update Section", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
				</mobile>
				<desktop>
					<div class="btn-toolbar">
						<div class="btn-group">
							{!! Form::button("Update Section", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
						</div>
					</div>
				</desktop>
			</div>
		</div>
	{!! Form::close() !!}
</div>