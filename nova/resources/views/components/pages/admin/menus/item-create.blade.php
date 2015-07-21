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

{!! Form::open(['route' => 'admin.menus.items.store', 'class' => 'form-horizontal']) !!}
	<div class="form-group{{ ($errors->has('title')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Title</label>
		<div class="col-md-5">
			{!! Form::text('title', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="col-md-5 col-md-offset-2">
		<div class="visible-xs visible-sm">
			{!! Form::button("Add Menu Item", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}
		</div>
		<div class="visible-md visible-lg">
			{!! Form::button("Add Menu Item", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
		</div>
	</div>
{!! Form::close() !!}