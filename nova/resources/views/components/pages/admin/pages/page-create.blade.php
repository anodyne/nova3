<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.pages') }}" class="btn btn-secondary btn-block">{!! icon('arrow-left') !!}<span>Back to Page Manager</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.pages') }}" class="btn btn-secondary">{!! icon('arrow-left') !!}<span>Back to Page Manager</span></a>
			</div>
		</div>
	</desktop>

	<div class="row">
		<div class="col-lg-10 col-xl-8 offset-lg-1 offset-xl-2">
			<div class="card-deck">
				<a role="button" @click="type='basic'" :class="pickerClassName('basic')">
					<div class="card-block">
						<h2>Basic Page</h2>
						{!! icon('file-text', 'x5') !!}
					</div>
				</a>

				<a role="button" @click="type='advanced'" :class="pickerClassName('advanced')">
					<div class="card-block">
						<h2>Advanced Page</h2>
						{!! icon('code', 'x5') !!}
					</div>
				</a>
			</div>
		</div>
	</div>

	{!! Form::open(['route' => 'admin.pages.store']) !!}
		{!! Form::hidden('type', null, ['v-model' => 'type']) !!}
		<div v-show="type != ''">
			<fieldset>
				<legend>Page Info</legend>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
							<label>Name</label>
							{!! Form::text('name', null, ['class' => 'form-control', 'v-model' => 'name']) !!}
							{!! $errors->first('name', '<small class="form-text">:message</small>') !!}
						</div>
					</div>
				</div>

				<div class="form-group">
					<label>Description</label>
					{!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3, 'v-model' => 'description']) !!}
				</div>

				<div class="row">
					<div class="col-md-8">
						<div class="form-group{{ ($errors->has('uri')) ? ' has-error' : '' }}">
							<label>URI</label>
							<div class="input-group">
								<div class="input-group-addon">{{ Request::root() }}/</div>
								{!! Form::text('uri', null, ['class' => 'form-control', 'v-model' => 'uri', '@change' => 'checkUri']) !!}
							</div>
							{!! $errors->first('uri', '<small class="form-text">:message</small>') !!}
							
							<small class="form-text" v-show="type == 'basic'">URIs identify and describe the resource (in this case, a page) that's being accessed with the following format: <code>foo/bar</code>. The only restrictions around URIs with basic pages is that they <strong>cannot</strong> have the same URI as another page and <strong>cannot</strong> use variables.</small>
							
							<small class="form-text" v-show="type == 'advanced'">URIs identify and describe the resource (in this case, a page) that's being accessed with the following format: <code>foo/bar</code>. You can also specify variables in your URIs to use in code by wrapping the name of the variable in braces: <code>foo/bar/{id}</code>. In your code, you'd then pass <code>$id</code> as a parameter to the method and be able to use whatever value is in the URI at that segment. Optional variables are indicated by a trailing question mark: <code>foo/bar/{id?}</code> and in your code, should have a default value to prevent errors. The only restriction around URIs with advanced pages is that they <strong>cannot</strong> have the same URI as another page.</small>
						</div>
					</div>
				</div>

				<div class="form-group" v-show="type == 'advanced'">
					<label>URI Conditions</label>
					{!! Form::textarea('conditions', null, ['class' => 'form-control', 'rows' => 3, 'v-model' => 'uriConditions']) !!}
					<small class="form-text">You can more closely control the content that can be put into URI parameters by defining conditions on any of the variables. URI conditions are period-delimited with the name of the variable first followed by the regular expression you want to use for evaluating the parameter: <code>name.[A-Za-z]+</code>. If you have multiple conditions for a URI, you can separate them with pipes: <code>name.[A-Za-z]+|id.[0-9]+</code>.</small>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
							<label>Key</label>
							{!! Form::text('key', null, ['class' => 'form-control', 'v-model' => 'key', '@change' => 'checkKey']) !!}
							{!! $errors->first('key', '<small class="form-text">:message</small>') !!}
							<small class="form-text">Keys are used to identify your pages and create dynamic links to them. Even if the URI of the page changes, using the key to build links means those links will continue to work as long as the key doesn't change. Keys <strong>must be</strong> unique.</small>
						</div>
					</div>
				</div>

				<div v-show="type == 'advanced'">
					<div class="form-group">
						<label>HTTP Verb</label>
						<div class="row">
							<div class="col-md-3">
								{!! Form::select('verb', $httpVerbs, null, ['class' => 'form-control', 'v-model' => 'verb']) !!}
							</div>
							<div class="col">
								<p><a href="#" class="btn btn-link" data-toggle="modal" data-target="#helpVerbs">What are HTTP Verbs?</a></p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<label>Resource</label>
								@if (is_array($resources))
									{!! Form::select('resource', $resources, null, ['class' => 'form-control', 'v-model' => 'resource']) !!}
								@else
									{!! alert('danger', $resources) !!}
								@endif
								<small class="form-text">The page resource is the controller and method that Nova will use when this page is called. Listed above are all the extension controllers and any public methods available in them.</small>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-8">
						<div class="form-group{{ ($errors->has('menu_id')) ? ' has-error' : '' }}">
							<label>Menu</label>
							{!! Form::select('menu_id', $menus, null, ['class' => 'form-control', 'v-model' => 'menu']) !!}
							{!! $errors->first('menu_id', '<small class="form-text">:message</small>') !!}
							<small class="form-text">Menu collections allow you to build menus for different areas of the system. When this page is the active page, the above menu collection will be rendered on the page.</small>
						</div>
					</div>
				</div>
			</fieldset>

			<div v-show="type == 'basic'">
				<fieldset>
					<legend>Restricting Access</legend>
					<p>You can restrict who has access to this page by the user's access role(s) or even permissions within their access role(s). By specifying either an access role or permission, Nova will require the visiting user to be logged in.</p>
					
					<div class="form-group">
						<!--{!! partial('access-picker', ['type' => '', 'selectedItems' => '[]']) !!}-->
					</div>
				</fieldset>				
			</div>

			<fieldset>
				<legend>Metadata</legend>

				<div class="data-table data-table-striped data-table-bordered">
					<div class="row">
						<div class="col-sm-4"><p><strong>Metadata Name</strong></p></div>
						<div class="col-sm-6"><p><strong>Value</strong></p></div>
						<div class="col-sm-2 hidden-xs hidden-sm"></div>
					</div>
					<div class="row" v-for="meta in metadata">
						<div class="col-sm-4">
							<p><input name="metadataNames[]" class="form-control" v-model="meta.name"></p>
						</div>
						<div class="col-sm-6">
							<p><input name="metadataValues[]" class="form-control" v-model="meta.value"></p>
						</div>
						<div class="col-xs-12 col-sm-2">
							<p><a href="#" @click.prevent="removeMetadata(meta)" class="btn btn-danger btn-block">{!! icon('close') !!}</a></p>
						</div>
					</div>
				</div>

				<mobile>
					<p><a @click="addMetadata()" class="btn btn-block btn-secondary">{!! icon('add') !!}<span>Add Attribute</span></a></p>
				</mobile>
				<desktop>
					<p><a @click="addMetadata()" class="btn btn-secondary">{!! icon('add') !!}<span>Add Attribute</span></a></p>
				</desktop>
			</fieldset>

			<fieldset>
				<legend>Content</legend>

				<div class="form-group{{ ($errors->has('content[title]')) ? ' has-error' : '' }}">
					<label>Page Title</label>
					{!! Form::text('content[title]', null, ['class' => 'form-control', 'v-model' => 'contentTitle']) !!}
					{!! $errors->first('content[title]', '<small class="form-text">:message</small>') !!}
					<small class="form-text">Page titles define the title of the document and are often used by search engine result pages as well as displayed in the title bar of the browser. The page title should be an accurate and concise description of the page's content.</small>
				</div>

				<div class="form-group{{ ($errors->has('content[header]')) ? ' has-error' : '' }}">
					<label>Page Header</label>
					{!! Form::text('content[header]', null, ['class' => 'form-control', 'v-model' => 'contentHeader']) !!}
					{!! $errors->first('content[header]', '<small class="form-text">:message</small>') !!}
					<small class="form-text">Page headers are displayed above the page's content and act as a title for the page.</small>
				</div>

				<div class="form-group{{ ($errors->has('content[message]')) ? ' has-error' : '' }}">
					<label>Content</label>
					{!! Form::textarea('content[message]', null, ['class' => 'form-control', 'rows' => 10, 'v-model' => 'contentMessage', 'placeholder' => 'Enter your content message here']) !!}
					{!! $errors->first('content[message]', '<small class="form-text">:message</small>') !!}

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
			</fieldset>

			<div class="form-group">
				<mobile>
					{!! Form::button("Add Page", ['class' => 'btn btn-primary btn-block', 'type' => 'submit']) !!}
				</mobile>
				<desktop>
					{!! Form::button("Add Page", ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
				</desktop>
			</div>
		</div>
	{!! Form::close() !!}

	{!! modal(['id' => 'helpVerbs', 'header' => "What Are HTTP Verbs?", 'body' => view(locate('page', 'admin/pages/help-verbs')), 'size' => 'modal-lg']) !!}
</div>