<div v-cloak>
	<phone-tablet>
		<p><a href="{{ route('admin.forms.sections', [$form->key]) }}" class="btn btn-default btn-lg btn-block">Back to Form Sections</a></p>
	</phone-tablet>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.forms.sections', [$form->key]) }}" class="btn btn-default">Back to Form Sections</a>
			</div>
		</div>
	</desktop>
</div>

{!! Form::model($section, ['route' => ['admin.forms.sections.update', $form->key, $section->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
	<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Name</label>
		<div class="col-md-5">
			{!! Form::text('name', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">Parent Tab</label>
		<div class="col-md-4">
			{!! Form::select('tab_id', $tabs, null, ['class' => 'form-control input-lg']) !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('status')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Status</label>
		<div class="col-md-5">
			<div>
				<div class="radio">
					<label>{!! Form::radio('status', Status::ACTIVE, true) !!} {{ ucwords(Status::toString(Status::ACTIVE)) }}</label>
				</div>
				<div class="radio">
					<label>{!! Form::radio('status', Status::INACTIVE) !!} {{ ucwords(Status::toString(Status::INACTIVE)) }}</label>
				</div>
			</div>
			{!! $errors->first('status', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-5 col-md-offset-2" v-cloak>
			<phone-tablet>
				<p>{!! Form::button("Update Section", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			</phone-tablet>
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