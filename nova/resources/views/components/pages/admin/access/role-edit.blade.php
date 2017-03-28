<div v-cloak>
	{!! Form::model($role, ['route' => ['admin.access.roles.update', $role->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Name</label>
			<div class="col-md-6">
				{!! Form::text('name', null, ['class' => 'form-control input-lg', 'v-model' => 'name', '@change' => 'updateName']) !!}
				{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Key</label>
			<div class="col-md-4">
				{!! Form::text('key', null, ['class' => 'form-control input-lg', 'v-model' => 'key', '@change' => 'updateKey']) !!}
				{!! $errors->first('key', '<p class="help-block">:message</p>') !!}
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<p class="help-block">Role keys are a unique name for the role primarily used for looking up role information quickly. This should not be confused with the name which is a human-readable form of the key.</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Description</label>
			<div class="col-md-6">
				{!! Form::textarea('description', null, ['class' => 'form-control input-lg', 'rows' => 4, 'v-model' => 'description']) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Permissions</label>
			<div class="col-md-9">
				<div class="data-table data-table-striped data-table-bordered">
					<div class="row">
						<div class="col-md-4">
							<p class="text-sm"><strong>Component</strong></p>
						</div>
						<div class="col-md-2">
							<p class="text-sm text-center"><strong>Create</strong></p>
						</div>
						<div class="col-md-2">
							<p class="text-sm text-center"><strong>Edit</strong></p>
						</div>
						<div class="col-md-2">
							<p class="text-sm text-center"><strong>Delete</strong></p>
						</div>
						<div class="col-md-2">
							<p class="text-sm text-center"><strong>View</strong></p>
						</div>
						<div class="col-md-4"></div>
					</div>

					@foreach ($permissions as $component => $permission)
						<div class="row">
							<div class="col-md-4">
								<p>{{ ucwords(str_replace('-', ' ', $component)) }}</p>
							</div>
							<div class="col-md-2">
								@if (array_key_exists('create', $permission))
									<p class="text-center">
										{!! Form::checkbox('permissions[]', $permission['create']->id, null, ['v-model' => 'permissions']) !!}
									</p>
								@endif
							</div>
							<div class="col-md-2">
								@if (array_key_exists('edit', $permission))
									<p class="text-center">
										{!! Form::checkbox('permissions[]', $permission['edit']->id, null, ['v-model' => 'permissions']) !!}
									</p>
								@endif
							</div>
							<div class="col-md-2">
								@if (array_key_exists('remove', $permission))
									<p class="text-center">
										{!! Form::checkbox('permissions[]', $permission['remove']->id, null, ['v-model' => 'permissions']) !!}
									</p>
								@endif
							</div>
							<div class="col-md-2">
								@if (array_key_exists('view', $permission))
									<p class="text-center">
										{!! Form::checkbox('permissions[]', $permission['view']->id, null, ['v-model' => 'permissions']) !!}
									</p>
								@endif
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<mobile>
					<p>{!! Form::button("Update Role", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
					<p><a href="{{ route('admin.access.roles') }}" class="btn btn-link-default btn-lg btn-block">Cancel</a></p>
				</mobile>
				<desktop>
					<div class="btn-toolbar">
						<div class="btn-group">
							{!! Form::button("Update Role", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
						</div>
						<div class="btn-group">
							<a href="{{ route('admin.access.roles') }}" class="btn btn-link-default btn-lg">Cancel</a>
						</div>
					</div>
				</desktop>
			</div>
		</div>
	{!! Form::close() !!}
</div>