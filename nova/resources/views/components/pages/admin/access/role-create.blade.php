<div v-cloak>
	{!! Form::open(['route' => 'admin.access.roles.store', 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Name</label>
			<div class="col-md-6">
				{!! Form::text('name', null, ['class' => 'form-control input-lg', 'v-model' => 'name', '@change' => 'updateName']) !!}
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
				<p class="help-block">Role keys are a unique name for the role mainly used for looking up role information quickly. This should not be confused with the name that is a human-readable form of the key.</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Description</label>
			<div class="col-md-8">
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
					<div class="row">
						<div class="col-md-4">
							<p>Access</p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-2"></div>
						<div class="col-md-4"></div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<p>Form</p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-2"></div>
						<div class="col-md-4"></div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<p>Form Center</p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox" checked disabled></p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-4"></div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<p>Menu</p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-2">
							<p class="text-center"><input type="checkbox"></p>
						</div>
						<div class="col-md-2"></div>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label">Permissions</label>
			<div class="col-md-9">
				@foreach ($permissions as $component => $permission)
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">{{ $component }}</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								@foreach ($permission as $p)
									<div class="col-md-4">
										<label class="checkbox-inline">
											{!! Form::checkbox('permissions[]', $p->id, false, ['v-model' => 'permissions']) !!}
											{!! $p->present()->name !!}
										</label>
									</div>
								@endforeach
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-3">
				<mobile>
					<p>{!! Form::button("Add Role", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
					<p><a href="{{ route('admin.access.roles') }}" class="btn btn-link-default btn-lg btn-block">Cancel</a></p>
				</mobile>
				<desktop>
					<div class="btn-toolbar">
						<div class="btn-group">
							{!! Form::button("Add Role", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
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