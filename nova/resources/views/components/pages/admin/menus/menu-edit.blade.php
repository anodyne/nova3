<div v-cloak>
	<phone-tablet>
		<p><a href="{{ route('admin.menus') }}" class="btn btn-default btn-lg btn-block">Back to Menu Manager</a></p>
	</phone-tablet>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.menus') }}" class="btn btn-default">Back to Menu Manager</a>
			</div>
		</div>
	</desktop>
</div>

{!! Form::model($menu, ['route' => ['admin.menus.update', $menu->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
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
		<div class="col-md-5 col-md-offset-2" v-cloak>
			<phone-tablet>
				<p>{!! Form::button("Update Menu", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			</phone-tablet>
			<desktop>
				<div class="btn-toolbar">
					<div class="btn-group">
						{!! Form::button("Update Menu", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
					</div>
				</div>
			</desktop>
		</div>
	</div>
{!! Form::close() !!}