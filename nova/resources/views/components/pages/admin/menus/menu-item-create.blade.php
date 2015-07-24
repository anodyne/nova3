{!! Form::open(['route' => 'admin.menus.items.store', 'class' => 'form-horizontal']) !!}
	<div class="form-group{{ ($errors->has('menu_id')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Menu</label>
		<div class="col-md-3">
			{!! Form::select('menu_id', $menus, $menuId, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('menu_id', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('title')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Title</label>
		<div class="col-md-5">
			{!! Form::text('title', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('type')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Type of Link</label>
		<div class="col-md-4">
			{!! Form::select('type', $linkTypes, null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div id="external-link" class="hide form-group{{ ($errors->has('link')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Link</label>
		<div class="col-md-6">
			{!! Form::text('link', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('link', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div id="page-link" class="hide form-group{{ ($errors->has('page_id')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Page</label>
		<div class="col-md-4">
			{!! Form::select('page_id', $pages, null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('page_id', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="col-md-5 col-md-offset-2">
		<div class="visible-xs visible-sm">
			<p>{!! Form::button("Add Menu Item", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			<p><a href="{{ route('admin.menus.items', [$menuId]) }}" class="btn btn-default btn-lg btn-block">Cancel</a></p>
		</div>
		<div class="visible-md visible-lg">
			<div class="btn-toolbar">
				<div class="btn-group">
					{!! Form::button("Add Menu Item", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
				</div>
				<div class="btn-group">
					<a href="{{ route('admin.menus.items', [$menuId]) }}" class="btn btn-default btn-lg">Cancel</a>
				</div>
			</div>
		</div>
	</div>
{!! Form::close() !!}