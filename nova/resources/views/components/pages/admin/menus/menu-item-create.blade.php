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

	{!! Form::open(['route' => 'admin.menus.items.store', 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('menu_id')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Menu</label>
			<div class="col-md-3">
				{!! Form::select('menu_id', $menus, $menuId, ['class' => 'form-control input-lg', 'v-model' => 'menuId']) !!}
				{!! $errors->first('menu_id', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('title')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Title</label>
			<div class="col-md-5">
				{!! Form::text('title', null, ['class' => 'form-control input-lg', 'v-model' => 'title']) !!}
				{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('type')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Type of Link</label>
			<div class="col-md-4">
				{!! Form::select('type', $linkTypes, null, ['class' => 'form-control input-lg', 'v-model' => 'type']) !!}
				{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div v-show="type != '' && type != 'page'" class="form-group{{ ($errors->has('link')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Link</label>
			<div class="col-md-6">
				{!! Form::text('link', null, ['class' => 'form-control input-lg', 'v-model' => 'link']) !!}
				{!! $errors->first('link', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div v-show="type == 'page'" class="form-group{{ ($errors->has('page_id')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Page</label>
			<div class="col-md-4">
				{!! Form::select('page_id', $pages, null, ['class' => 'form-control input-lg', 'v-model' => 'pageId']) !!}
				{!! $errors->first('page_id', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Icon</label>
			<div class="col-md-4">
				{!! partial('icon-picker', ['icon' => '']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-7 col-md-offset-2">
				<h3>Controlling Access</h3>
				<p>You can restrict who has access to the page by the user's access role or even permission keys that are within the access role(s). By specifying either an access role or permission, Nova will require the visiting user to be logged in.</p>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-7 col-md-offset-2">
				{!! partial('access-picker', ['type' => '', 'selectedItems' => '[]']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-5 col-md-offset-2">
				<mobile>
					<p>{!! Form::button("Add Menu Item", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
				</mobile>
				<desktop>
					<div class="btn-toolbar">
						<div class="btn-group">
							{!! Form::button("Add Menu Item", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
						</div>
					</div>
				</desktop>
			</div>
		</div>
	{!! Form::close() !!}
</div>