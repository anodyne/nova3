<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.menus.items', [$menuId]) }}" class="btn btn-default btn-lg btn-block">Back to Menu Items</a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.menus.items', [$menuId]) }}" class="btn btn-default">Back to Menu Items</a>
			</div>
		</div>
	</desktop>
</div>

{!! Form::model($item, ['route' => ['admin.menus.items.update', $item->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
	<div class="form-group{{ ($errors->has('menu_id')) ? ' has-error' : '' }}">
		<label class="col-md-3 control-label">Menu</label>
		<div class="col-md-3">
			{!! Form::select('menu_id', $menus, $item->menu->id, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('menu_id', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('title')) ? ' has-error' : '' }}">
		<label class="col-md-3 control-label">Title</label>
		<div class="col-md-5">
			{!! Form::text('title', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('authentication')) ? ' has-error' : '' }}">
		<label class="col-md-3 control-label">Require Authentication</label>
		<div class="col-md-5">
			<label class="radio-inline">
				{!! Form::radio('authentication', (int) true, ($item->authentication === true)) !!} Yes
			</label>
			<label class="radio-inline">
				{!! Form::radio('authentication', (int) false, ($item->authentication === false)) !!} No
			</label>
			{!! $errors->first('authentication', '<p class="help-block">:message</p>') !!}
			<p class="help-block">Does the user need to be logged in to see this menu item?</p>
		</div>
	</div>

	<div class="form-group{{ ($errors->has('type')) ? ' has-error' : '' }}">
		<label class="col-md-3 control-label">Type of Link</label>
		<div class="col-md-4">
			{!! Form::select('type', $linkTypes, null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div id="external-link" class="hide form-group{{ ($errors->has('link')) ? ' has-error' : '' }}">
		<label class="col-md-3 control-label">Link</label>
		<div class="col-md-6">
			{!! Form::text('link', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('link', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div id="page-link" class="hide form-group{{ ($errors->has('page_id')) ? ' has-error' : '' }}">
		<label class="col-md-3 control-label">Page</label>
		<div class="col-md-4">
			{!! Form::select('page_id', $pages, null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('page_id', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-5 col-md-offset-3" v-cloak>
			<mobile>
				<p>{!! Form::button("Update Menu Item", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			</mobile>
			<desktop>
				<div class="btn-toolbar">
					<div class="btn-group">
						{!! Form::button("Update Menu Item", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
					</div>
				</div>
			</desktop>
		</div>
	</div>
{!! Form::close() !!}