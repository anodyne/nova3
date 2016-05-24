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

	{!! Form::open(['route' => 'admin.pages.store', 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('type')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Page Type</label>
			<div class="col-md-5">
				<div class="radio">
					<label>
						{!! Form::radio('type', 'basic', false, ['v-model' => 'type']) !!} Basic Page
					</label>
				</div>
				<div class="radio">
					<label>
						{!! Form::radio('type', 'advanced', false, ['v-model' => 'type']) !!} Advanced Page
					</label>
				</div>
				{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div v-show="type != ''">
			<div class="form-group">
				<div class="col-md-5 col-md-offset-2">
					<h3>Page Info</h3>
				</div>
			</div>

			<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
				<label class="col-md-2 control-label">Name</label>
				<div class="col-md-5">
					{!! Form::text('name', null, ['class' => 'form-control input-lg', 'v-model' => 'name']) !!}
					{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label">Description</label>
				<div class="col-md-6">
					{!! Form::textarea('description', null, ['class' => 'form-control input-lg', 'rows' => 3, 'v-model' => 'description']) !!}
				</div>
			</div>

			<div class="form-group{{ ($errors->has('uri')) ? ' has-error' : '' }}">
				<label class="col-md-2 control-label">URI</label>
				<div class="col-md-8">
					<div class="input-group">
						<span class="input-group-addon">{{ Request::root() }}/</span>
						{!! Form::text('uri', null, ['class' => 'form-control input-lg', 'v-model' => 'uri', '@change' => 'checkUri']) !!}
					</div>
					{!! $errors->first('uri', '<p class="help-block">:message</p>') !!}
					<p class="help-block" v-show="type == 'basic'">URIs identify and describe the resource (in this case, a page) that's being accessed with the following format: <code>foo/bar</code>. The only restrictions around URIs with basic pages is that they <strong>cannot</strong> have the same URI as another page and <strong>cannot</strong> use variables.</p>
					<p class="help-block" v-show="type == 'advanced'">URIs identify and describe the resource (in this case, a page) that's being accessed with the following format: <code>foo/bar</code>. You can also specify variables in your URIs to use in code by wrapping the name of the variable in braces: <code>foo/bar/{id}</code>. In your code, you'd then pass <code>$id</code> as a parameter to the method and be able to use whatever value is in the URI at that segment. Optional variables are indicated by a trailing question mark: <code>foo/bar/{id?}</code> and in your code, should have a default value to prevent errors. The only restriction around URIs with advanced pages is that they <strong>cannot</strong> have the same URI as another page.</p>
				</div>
			</div>

			<div class="form-group" v-show="type == 'advanced'">
				<label class="col-md-2 control-label">URI Conditions</label>
				<div class="col-md-6">
					{!! Form::textarea('conditions', null, ['class' => 'form-control input-lg', 'rows' => 3, 'v-model' => 'uriConditions']) !!}
					<p class="help-block">You can more closely control the content that can be put into URI parameters by defining conditions on any of the variables. URI conditions are period-delimited with the name of the variable first followed by the regular expression you want to use for evaluating the parameter: <code>name.[A-Za-z]+</code>. If you have multiple conditions for a URI, you can separate them with pipes: <code>name.[A-Za-z]+|id.[0-9]+</code>.</p>
				</div>
			</div>

			<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
				<label class="col-md-2 control-label">Key</label>
				<div class="col-md-5">
					{!! Form::text('key', null, ['class' => 'form-control input-lg', 'v-model' => 'key', '@change' => 'checkKey']) !!}
					{!! $errors->first('key', '<p class="help-block">:message</p>') !!}
					<p class="help-block">Keys are used to uniquely identify your pages and create dynamic links to them. Even if the URI or other values of the page change, using the key to build links means that those links will always work as long as the key doesn't change. The only restriction with keys is that they <strong>cannot</strong> have the same key as another page.</p>
				</div>
			</div>

			<div v-show="type == 'advanced'">
				<div class="form-group">
					<label class="col-md-2 control-label">HTTP Verb</label>
					<div class="col-md-2">
						{!! Form::select('verb', $httpVerbs, null, ['class' => 'form-control input-lg', 'v-model' => 'verb']) !!}
					</div>
					<div class="col-md-2">
						<p><a href="#" class="btn btn-link btn-lg" data-toggle="modal" data-target="#helpVerbs">What are HTTP Verbs?</a></p>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-2 control-label">Resource</label>
					<div class="col-md-6">
						@if (is_array($resources))
							{!! Form::select('resource', $resources, null, ['class' => 'form-control input-lg', 'v-model' => 'resource']) !!}
						@else
							{!! alert('danger', $resources) !!}
						@endif
						<p class="help-block">The page resource is the controller and method that Nova will use when this page is called. Listed above are all the extension controllers and any public methods available in them.</p>
					</div>
				</div>
			</div>

			<div class="form-group{{ ($errors->has('menu_id')) ? ' has-error' : '' }}">
				<label class="col-md-2 control-label">Menu</label>
				<div class="col-md-5">
					{!! Form::select('menu_id', $menus, null, ['class' => 'form-control input-lg', 'v-model' => 'menu']) !!}
					{!! $errors->first('menu_id', '<p class="help-block">:message</p>') !!}
					<p class="help-block">Menu collections allow you to build menus for different areas of the system. When this page is the active page, the above menu collection will be rendered on the page.</p>
				</div>
			</div>

			<div v-show="type == 'basic'">
				<div class="form-group">
					<div class="col-md-7 col-md-offset-2">
						<h3>Restricting Access</h3>
						<p>You can restrict who has access to this page by the user's access role(s) or even permissions within their access role(s). By specifying either an access role or permission, Nova will require the visiting user to be logged in.</p>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-7 col-md-offset-2">
						{!! partial('access-picker', ['type' => '', 'selectedItems' => '[]']) !!}
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-5 col-md-offset-2">
					<h3>Content</h3>
				</div>
			</div>

			<div class="form-group{{ ($errors->has('content[title]')) ? ' has-error' : '' }}">
				<label class="col-md-2 control-label">Page Title</label>
				<div class="col-md-6">
					{!! Form::text('content[title]', null, ['class' => 'form-control input-lg', 'v-model' => 'contentTitle']) !!}
					{!! $errors->first('content[title]', '<p class="help-block">:message</p>') !!}
					<p class="help-block">Page titles define the title of the document and are often used by search engine result pages as well as displayed in the title bar of the browser. The page title should be an accurate and concise description of the page's content.</p>
				</div>
			</div>

			<div class="form-group{{ ($errors->has('content[header]')) ? ' has-error' : '' }}">
				<label class="col-md-2 control-label">Page Header</label>
				<div class="col-md-6">
					{!! Form::text('content[header]', null, ['class' => 'form-control input-lg', 'v-model' => 'contentHeader']) !!}
					{!! $errors->first('content[header]', '<p class="help-block">:message</p>') !!}
					<p class="help-block">Page headers are displayed above the page's content and act as a title for the page.</p>
				</div>
			</div>

			<div class="form-group{{ ($errors->has('content[message]')) ? ' has-error' : '' }}">
				<label class="col-md-2 control-label">Content</label>
				<div class="col-md-8">
					{!! Form::textarea('content[message]', null, ['class' => 'form-control input-lg editor', 'rows' => 10, 'v-model' => 'contentMessage', 'placeholder' => 'Enter your content message here']) !!}
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

			<div class="col-md-5 col-md-offset-2">
				<mobile>
					{!! Form::button("Add Page", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}
				</mobile>
				<desktop>
					{!! Form::button("Add Page", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
				</desktop>
			</div>
		</div>
	{!! Form::close() !!}

	{!! modal(['id' => 'helpVerbs', 'header' => "What Are HTTP Verbs?", 'body' => view(locate('page', 'admin/pages/help-verbs'))]) !!}
</div>