<div v-cloak>
	{!! Form::model($permission, ['route' => ['admin.access.permissions.update', $permission->id], 'class' => 'form-horizontal', 'method' => 'put']) !!}
		<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Name</label>
			<div class="col-md-5">
				{!! Form::text('name', null, ['class' => 'form-control input-lg', 'v-model' => 'name']) !!}
				{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Key</label>
			<div class="col-md-3">
				{!! Form::text('key', null, ['class' => 'form-control input-lg', 'v-model' => 'key', '@change' => 'updateKey']) !!}
				{!! $errors->first('key', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-8 col-md-offset-3">
				<p class="help-block">Permission keys must be in the format of <code>component.action</code>, like <code>page.create</code>. If you need to provide levels within an action, simply append the level number to the end of the action: <code>post.edit.2</code>.</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Description</label>
			<div class="col-md-8">
				{!! Form::textarea('description', null, ['class' => 'form-control input-lg', 'rows' => 4, 'v-model' => 'description']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-8 col-md-offset-3">
				<mobile>
					<p>{!! Form::button("Update Permission", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
					<p><a href="{{ route('admin.access.permissions') }}" class="btn btn-link-default btn-lg btn-block">Cancel</a></p>
				</mobile>
				<desktop>
					<div class="btn-toolbar">
						<div class="btn-group">
							{!! Form::button("Update Permission", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
						</div>
						<div class="btn-group">
							<a href="{{ route('admin.access.permissions') }}" class="btn btn-link-default btn-lg">Cancel</a>
						</div>
					</div>
				</desktop>
			</div>
		</div>
	{!! Form::close() !!}
</div>