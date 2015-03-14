<div class="visible-xs visible-sm">
	<p><a href="{{ route('admin.pages') }}" class="btn btn-default btn-lg btn-block">Page Manager</a></p>
</div>
<div class="visible-md visible-lg">
	<div class="btn-toolbar">
		<div class="btn-group">
			<a href="{{ route('admin.pages') }}" class="btn btn-default">Page Manager</a>
		</div>
	</div>
</div>

{!! Form::open(['route' => 'admin.pages.store', 'class' => 'form-horizontal']) !!}
	<div class="form-group">
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
		</div>
	</div>

	<div id="pageBasic" class="hide">
		<div class="form-group">
			<div class="col-md-5 col-md-offset-2">
				<h3>Page Info</h3>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Name</label>
			<div class="col-md-5">
				{!! Form::text('basic[name]', null, ['class' => 'form-control input-lg']) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Description</label>
			<div class="col-md-8">
				{!! Form::textarea('basic[description]', null, ['class' => 'form-control input-lg', 'rows' => 3]) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Key</label>
			<div class="col-md-3">
				{!! Form::text('basic[key]', null, ['class' => 'form-control input-lg']) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">URI</label>
			<div class="col-md-6">
				<div class="input-group">
					<span class="input-group-addon">{{ Request::root() }}/</span>
					{!! Form::text('basic[uri]', null, ['class' => 'form-control input-lg']) !!}
				</div>
			</div>
		</div>
	</div>

	<div id="pageAdvanced" class="hide">
		<div class="form-group">
			<div class="col-md-5 col-md-offset-2">
				<h3>Page Info</h3>
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
			<label class="col-md-2 control-label">Key</label>
			<div class="col-md-3">
				{!! Form::text('advanced[key]', null, ['class' => 'form-control input-lg']) !!}
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

		<div class="form-group">
			<label class="col-md-2 control-label">Conditions</label>
			<div class="col-md-5">
				{!! Form::textarea('advanced[conditions]', null, ['class' => 'form-control input-lg', 'rows' => 3]) !!}
			</div>
		</div>
	</div>

	<div id="pageContent" class="hide">
		<div class="form-group">
			<div class="col-md-5 col-md-offset-2">
				<h3>Content</h3>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Page Title</label>
			<div class="col-md-5">
				{!! Form::text('content[title]', null, ['class' => 'form-control input-lg']) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Page Header</label>
			<div class="col-md-5">
				{!! Form::text('content[header]', null, ['class' => 'form-control input-lg']) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Content</label>
			<div class="col-md-8">
				{!! Form::textarea('content[message]', null, ['class' => 'form-control input-lg', 'rows' => 10]) !!}
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

	<div class="form-group">
		<div class="col-md-5 col-md-offset-2">
			<div class="visible-xs visible-sm">
				{!! Form::button('Create Page', ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}
			</div>
			<div class="visible-md visible-lg">
				{!! Form::button('Create Page', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
			</div>
		</div>
	</div>
{!! Form::close() !!}