<div class="visible-xs visible-sm">
	<p><a href="{{ route('admin.menus') }}" class="btn btn-default btn-lg btn-block">Back to Menu Manager</a></p>
</div>
<div class="visible-md visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('admin.menus') }}" class="btn btn-default">Back to Menu Manager</a>
		</div>
	</div>
</div>

{!! Form::open(['route' => 'admin.menus.store', 'class' => 'form-horizontal']) !!}
	<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Name</label>
		<div class="col-md-5">
			{!! Form::text('name', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Key</label>
		<div class="col-md-3">
			{!! Form::text('key', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('key', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-5 col-md-offset-2">
			<div class="visible-xs visible-sm">
				<p>{!! Form::button("Add Menu", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			</div>
			<div class="visible-md visible-lg">
				<div class="btn-toolbar">
					<div class="btn-group">
						{!! Form::button("Add Menu", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
{!! Form::close() !!}