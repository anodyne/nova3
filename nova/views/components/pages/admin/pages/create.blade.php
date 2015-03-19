<div class="visible-xs visible-sm">
	<p><a href="{{ route('admin.pages') }}" class="btn btn-default btn-lg btn-block">Back to Page Manager</a></p>
</div>
<div class="visible-md visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('admin.pages') }}" class="btn btn-default">Back to Page Manager</a>
		</div>
	</div>
</div>

{!! Form::open(['route' => 'admin.pages.store', 'class' => 'form-horizontal']) !!}
	<div class="form-group{{ ($errors->has('type')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Page Type</label>
		<div class="col-md-5">
			<div class="radio">
				<label>
					{!! Form::radio('type', 'basic', false) !!} Basic Page
				</label>
			</div>
			<div class="radio">
				<label>
					{!! Form::radio('type', 'advanced', false) !!} Advanced Page
				</label>
			</div>
			{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
		</div>
	</div>

	<div id="pageBasic" class="hide">
		<div class="form-group">
			<div class="col-md-5 col-md-offset-2">
				<h3>Page Info</h3>
			</div>
		</div>

		<div class="form-group{{ ($errors->has('basic[name]')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Name</label>
			<div class="col-md-5">
				{!! Form::text('basic[name]', null, ['class' => 'form-control input-lg']) !!}
				{!! $errors->first('basic[name]', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Description</label>
			<div class="col-md-8">
				{!! Form::textarea('basic[description]', null, ['class' => 'form-control input-lg', 'rows' => 3]) !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('basic[uri]')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">URI</label>
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">{{ Request::root() }}/</span>
					{!! Form::text('basic[uri]', null, ['class' => 'form-control input-lg']) !!}
				</div>
				{!! $errors->first('basic[uri]', '<p class="help-block">:message</p>') !!}
				<p class="help-block">URIs are part of the address where the page lives, should describe the resource being accessed, and should be in the following format: <code>foo/bar</code>. You <strong>cannot</strong> specify variables in URIs for basic pages. If you do, your page will throw an error!</p>
			</div>
		</div>

		<div class="form-group{{ ($errors->has('basic[key]')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Key</label>
			<div class="col-md-4">
				{!! Form::text('basic[key]', null, ['class' => 'form-control input-lg']) !!}
				{!! $errors->first('basic[key]', '<p class="help-block">:message</p>') !!}
				<p class="help-block">The key used to create a named route that allows for quickly and easily building dynamic links to the page.</p>
			</div>
		</div>
	</div>

	<div id="pageAdvanced" class="hide">
		<div class="form-group">
			<div class="col-md-8 col-md-offset-2">
				<h3>Page Info</h3>

				<dl>
					<dt>Name</dt>

					<dt>Description</dt>
					<dd>The page description will be put into the page's <code>description</code> metatag and picked by search engines when indexing your site.</dd>

					<dt>URI</dt>
					<dd>URIs are part of the address where the page lives, should describe the resource being accessed, and should be in the following format: <code>foo/bar</code>. You can specify variables in your URIs to use in code by wrapping the name of the variable in braces: <code>foo/bar/{id}</code>. Optional variables are indicated by a trailing question mark: <code>foo/bar/{id?}</code>.</dd>

					<dt>Key</dt>
					<dd>The key used to create a named route that allows for quickly and easily building dynamic links to the page. Keys <strong>should not</strong> contain any variables found in your URI!</dd>

					<dt>HTTP Verb</dt>

					<dt>Resource</dt>
					<dd>The page resource must be a class name (including its namespace) and method that tells {{ config('nova.app.name') }} what code it should use when this page's URI is requested. Resources should be in the following format: <code>Foo\Bar\Baz@method</code>.</dd>

					<dt>Conditions</dt>
				</dl>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Name</label>
			<div class="col-md-5">
				{!! Form::text('advanced[name]', null, ['class' => 'form-control input-lg']) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Description</label>
			<div class="col-md-8">
				{!! Form::textarea('advanced[description]', null, ['class' => 'form-control input-lg', 'rows' => 3]) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">URI</label>
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">{{ Request::root() }}/</span>
					{!! Form::text('advanced[uri]', null, ['class' => 'form-control input-lg']) !!}
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">URI Conditions</label>
			<div class="col-md-5">
				{!! Form::textarea('advanced[conditions]', null, ['class' => 'form-control input-lg', 'rows' => 3]) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Key</label>
			<div class="col-md-4">
				{!! Form::text('advanced[key]', null, ['class' => 'form-control input-lg']) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">HTTP Verb</label>
			<div class="col-md-2">
				{!! Form::select('advanced[verb]', $httpVerbs, null, ['class' => 'form-control input-lg']) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Resource</label>
			<div class="col-md-8">
				{!! Form::text('advanced[resource]', null, ['class' => 'form-control input-lg']) !!}
			</div>
		</div>
	</div>

	<div id="pageContent" class="hide">
		<div class="form-group">
			<div class="col-md-5 col-md-offset-2">
				<h3>Content</h3>
			</div>
		</div>

		<div class="form-group{{ ($errors->has('content[title]')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Page Title</label>
			<div class="col-md-5">
				{!! Form::text('content[title]', null, ['class' => 'form-control input-lg']) !!}
				{!! $errors->first('content[title]', '<p class="help-block">:message</p>') !!}
				<p class="help-block">Page titles define the title of the document and are often used by search engine result pages. The page title should be an accurate and concise description of the page's content.</p>
			</div>
		</div>

		<div class="form-group{{ ($errors->has('content[header]')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Page Header</label>
			<div class="col-md-5">
				{!! Form::text('content[header]', null, ['class' => 'form-control input-lg']) !!}
				{!! $errors->first('content[header]', '<p class="help-block">:message</p>') !!}
				<p class="help-block">Page headers are displayed above the page's content and act as a title for the page being viewed.</p>
			</div>
		</div>

		<div class="form-group{{ ($errors->has('content[message]')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Content</label>
			<div class="col-md-8">
				{!! Form::textarea('content[message]', null, ['class' => 'form-control input-lg', 'rows' => 10]) !!}
				{!! $errors->first('content[message]', '<p class="help-block">:message</p>') !!}
				<p class="help-block">
					<ul>
					@foreach (app('nova.page.compiler')->getCompilers() as $compiler)
						<li>{!! Markdown::parse($compiler->help()) !!}</li>
					@endforeach
					</ul>
				</p>
			</div>
		</div>
	</div>

	<div id="pageControls" class="form-group hide">
		<div class="col-md-5 col-md-offset-2">
			<div class="visible-xs visible-sm">
				{!! Form::button("Add Page", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}
			</div>
			<div class="visible-md visible-lg">
				{!! Form::button("Add Page", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
			</div>
		</div>
	</div>
{!! Form::close() !!}