<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.access.permissions') }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Permissions</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.access.permissions') }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Permissions</span></a>
			</div>
		</div>
	</desktop>
</div>

{!! Form::open(['route' => 'admin.access.permissions.store', 'class' => 'form-horizontal']) !!}
	<div class="form-group{{ ($errors->has('display_name')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Name</label>
		<div class="col-md-5">
			{!! Form::text('display_name', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('display_name', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('component')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Component</label>
		<div class="col-md-3">
			{!! Form::text('component', null, ['class' => 'form-control input-lg', 'v-model' => 'component', 'v-on:change' => 'updateKey']) !!}
			{!! $errors->first('component', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-5 col-md-offset-2">
			<p class="help-block">Permission components should describe the <em>noun</em> the action is being taken on (e.g. page, rank, menu, etc.).</p>
		</div>
	</div>

	<div class="form-group{{ ($errors->has('action')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Action</label>
		<div class="col-md-3">
			{!! Form::text('action', null, ['class' => 'form-control input-lg', 'v-model' => 'action', 'v-on:change' => 'updateKey']) !!}
			{!! $errors->first('action', '<p class="help-block">:message</p>') !!}
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-5 col-md-offset-2">
			<p class="help-block">Permission actions should describe the <em>action</em> being taken on the component (e.g. create, edit, delete, view). If you want to specific levels within an action, you can append <code>.{n}</code> where <code>{n}</code> is a numeric value.</p>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">Key</label>
		<div class="col-md-5">
			<p class="form-control-static" v-if="key != ''">@{{ key }}</p>
			<p class="form-control-static text-warning" v-if="key == ''">Please enter a component and action.</p>
			{!! Form::hidden('name', null, ['v-model' => 'key']) !!}
    	</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">Description</label>
		<div class="col-md-6">
			{!! Form::textarea('description', null, ['class' => 'form-control input-lg', 'rows' => 4]) !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-5 col-md-offset-2" v-cloak>
			<mobile>
				<p>{!! Form::button("Add Permission", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			</mobile>
			<desktop>
				<div class="btn-toolbar">
					<div class="btn-group">
						{!! Form::button("Add Permission", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
					</div>
				</div>
			</desktop>
		</div>
	</div>
{!! Form::close() !!}