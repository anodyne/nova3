<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.pages') }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Page Manager</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.pages') }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Page Manager</span></a>
			</div>
		</div>
	</desktop>

	{!! Form::model($page, ['route' => ['admin.pages.update', $page->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Name</label>
			<div class="col-md-5">
				{!! Form::text('name', null, ['class' => 'form-control input-lg', 'v-model' => 'name']) !!}
				{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Description</label>
			<div class="col-md-8">
				{!! Form::textarea('description', null, ['class' => 'form-control input-lg', 'rows' => 3, 'v-model' => 'description']) !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('uri')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">URI</label>
			<div class="col-md-8">
				<div class="input-group">
					<span class="input-group-addon">{{ Request::root() }}/</span>
					{!! Form::text('uri', null, ['class' => 'form-control input-lg', 'v-model' => 'uri']) !!}
				</div>
				{!! $errors->first('uri', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Key</label>
			<div class="col-md-5">
				{!! Form::text('key', null, ['class' => 'form-control input-lg', 'v-model' => 'key']) !!}
				{!! $errors->first('key', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('menu_id')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Menu</label>
			<div class="col-md-5">
				{!! Form::select('menu_id', $menus, null, ['class' => 'form-control input-lg', 'v-model' => 'menu']) !!}
				{!! $errors->first('menu_id', '<p class="help-block">:message</p>') !!}
				<p class="help-block">Menu collections allow you to build menus for different areas of the system. When this page is the active page, the above menu collection will be rendered on the page. Some pages (such as POST, PUT, and DELETE pages as well as any pop-ups) do not need to have a menu collection.</p>
			</div>
		</div>

		@if ($page->type == 'basic')
			<div class="form-group">
				<div class="col-md-7 col-md-offset-2">
					<h3>Restricting Access</h3>
					<p>You can restrict who has access to this page by the user's access role(s) or even permissions within their access role(s). By specifying either an access role or permission, Nova will require the visiting user to be logged in.</p>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-7 col-md-offset-2">
					{!! partial('access-picker', ['type' => $page->access_type, 'selectedItems' => $page->access->toJson()]) !!}
				</div>
			</div>
		@endif

		@if ($page->type == 'advanced')
			<div class="form-group{{ ($errors->has('verb')) ? ' has-error' : '' }}">
				<label class="col-md-2 control-label">HTTP Verb</label>
				<div class="col-md-2">
					{!! Form::select('verb', $httpVerbs, null, ['class' => 'form-control input-lg', 'v-model' => 'verb']) !!}
					{!! $errors->first('verb', '<p class="help-block">:message</p>') !!}
				</div>
				<div class="col-md-2">
					<p><a href="#" class="btn btn-link btn-lg" data-toggle="modal" data-target="#helpVerbs">What are HTTP Verbs?</a></p>
				</div>
			</div>

			<div class="form-group{{ ($errors->has('resource')) ? ' has-error' : '' }}">
				<label class="col-md-2 control-label">Resource</label>
				<div class="col-md-6">
					@if (is_array($resources))
						{!! Form::select('resource', $resources, null, ['class' => 'form-control input-lg', 'v-model' => 'resource']) !!}
					@else
						{!! alert('danger', $resources) !!}
					@endif
					{!! $errors->first('resource', '<p class="help-block">:message</p>') !!}
				</div>
				@if ($page->protected)
					<div class="col-md-2">
						<a href="#" class="btn btn-default btn-lg btn-block" @click.prevent="resetResource">Reset</a>
					</div>
				@endif
			</div>

			@if ($page->protected)
				<div class="form-group">
					<label class="col-md-2 control-label">Default Resource</label>
					<div class="col-md-8">
						<p class="form-control-static"><code>{{ $page->present()->defaultResource }}</code></p>
					</div>
				</div>
			@endif
		@else
			{!! Form::hidden('verb', 'GET', ['v-model' => 'verb']) !!}
			{!! Form::hidden('resource', $page->present()->defaultResource, ['v-model' => 'resource']) !!}
		@endif

		<div class="form-group">
			<div class="col-md-5 col-md-offset-2">
				<h3>Content</h3>
			</div>
		</div>

		<div class="form-group{{ ($errors->has('content[title]')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Page Title</label>
			<div class="col-md-5">
				{!! Form::text('content[title]', $page->present()->title, ['class' => 'form-control input-lg', 'v-model' => 'contentTitle']) !!}
				{!! $errors->first('content[title]', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('content[header]')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Page Header</label>
			<div class="col-md-5">
				{!! Form::text('content[header]', $page->present()->header, ['class' => 'form-control input-lg', 'v-model' => 'contentHeader']) !!}
				{!! $errors->first('content[header]', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('content[message]')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Content</label>
			<div class="col-md-8">
				{!! Form::textarea('content[message]', $page->present()->messageRaw, ['class' => 'form-control input-lg', 'rows' => 10, 'v-model' => 'contentMessage']) !!}
				{!! $errors->first('content[message]', '<p class="help-block">:message</p>') !!}
				
				<ul class="nav nav-pills nav-pills-sm">
					<li><a href="#help-markdown" data-toggle="pill">Markdown Help</a></li>
					<li><a href="#help-compilers" data-toggle="pill">Page Compilers Help</a></li>
				</ul>
				<div class="tab-content">
					<div id="help-markdown" class="tab-pane">
						{!! partial('help-markdown') !!}
					</div>
					<div id="help-compilers" class="tab-pane">
						{!! partial('help-compilers') !!}
					</div>
				</div>
			</div>
		</div>

		{!! Form::hidden('type', null, ['v-model' => 'type']) !!}
		{!! Form::hidden('protected', (int) $page->protected, ['v-model' => 'protected']) !!}

		<div class="col-md-5 col-md-offset-2">
			<mobile>
				{!! Form::button("Update Page", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}
			</mobile>
			<desktop>
				{!! Form::button("Update Page", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
			</desktop>
		</div>
	{!! Form::close() !!}

	{!! modal(['id' => 'helpVerbs', 'header' => "What Are HTTP Verbs?", 'body' => view(locate('page', 'admin/pages/help-verbs'))]) !!}
</div>