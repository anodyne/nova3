<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.menus.items', [$menuId]) }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Menu Items</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.menus.items', [$menuId]) }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Menu Items</span></a>
			</div>
		</div>
	</desktop>

	{!! Form::model($item, ['route' => ['admin.menus.items.update', $item->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('menu_id')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Menu</label>
			<div class="col-md-3">
				{!! Form::select('menu_id', $menus, $item->menu->id, ['class' => 'form-control input-lg', 'v-model' => 'menuId']) !!}
				{!! $errors->first('menu_id', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('title')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Title</label>
			<div class="col-md-5">
				{!! Form::text('title', null, ['class' => 'form-control input-lg', 'v-model' => 'title']) !!}
				{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('authentication')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Require Authentication</label>
			<div class="col-md-5">
				<div>
					<div class="radio">
						<label>{!! Form::radio('authentication', (int) true, ($item->authentication === true)) !!} Yes</label>
					</div>
					<div class="radio">
						<label>{!! Form::radio('authentication', (int) false, ($item->authentication === false)) !!} No</label>
					</div>
				</div>
				{!! $errors->first('authentication', '<p class="help-block">:message</p>') !!}
				<p class="help-block">Does the user need to be logged in to see this menu item?</p>
			</div>
		</div>

		<div class="form-group{{ ($errors->has('type')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Type of Link</label>
			<div class="col-md-4">
				{!! Form::select('type', $linkTypes, null, ['class' => 'form-control input-lg', 'v-model' => 'type', '@change' => 'resetTypeFields']) !!}
				{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div v-show="type != '' && type != 'page'" class="form-group{{ ($errors->has('link')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Link</label>
			<div class="col-md-6">
				{!! Form::text('link', null, ['class' => 'form-control input-lg', 'v-model' => 'link']) !!}
				{!! $errors->first('link', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div v-show="type == 'page'" class="form-group{{ ($errors->has('page_id')) ? ' has-error' : '' }}">
			<label class="col-md-3 control-label">Page</label>
			<div class="col-md-4">
				{!! Form::select('page_id', $pages, null, ['class' => 'form-control input-lg', 'v-model' => 'pageId']) !!}
				{!! $errors->first('page_id', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-5 col-md-offset-3">
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
</div>