<div class="page-header">
	<h1>Edit Page <small>{{ $page->present()->name }}</small></h1>
</div>

<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ route('admin.pages') }}" class="btn btn-default">Page Manager</a>
	</div>
</div>

{!! Form::model($page, ['class' => 'form-horizontal']) !!}
	<div class="form-group">
		<label class="col-md-2 control-label">Name</label>
		<div class="col-md-5">
			{!! Form::text('name', null, ['class' => 'form-control input-lg']) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">Description</label>
		<div class="col-md-7">
			{!! Form::textarea('description', null, ['class' => 'form-control input-lg', 'rows' => 2]) !!}
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-7 col-md-offset-2">
			<h3>Routing Info</h3>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">Key</label>
		<div class="col-md-5">
			{!! Form::text('key', null, ['class' => 'form-control input-lg']) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">Resource Type</label>
		<div class="col-md-2">
			{!! Form::select('verb', $httpVerbs, null, ['class' => 'form-control input-lg']) !!}
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">URI</label>
		<div class="col-md-7">
			<div class="input-group">
				{!! Form::text('uri', null, ['class' => 'form-control input-lg']) !!}
				<span class="input-group-btn">
					<button class="btn btn-default btn-lg" type="button">Help</button>
				</span>
			</div>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">Default Resource</label>
		<div class="col-md-10">
			<p class="form-control-static">{{ $page->present()->default_resource }}</p>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">New Resource</label>
		<div class="col-md-7">
			<div class="input-group">
				{!! Form::text('resource', null, ['class' => 'form-control input-lg']) !!}
				<span class="input-group-btn">
					<button class="btn btn-default btn-lg" type="button">Reset</button>
				</span>
			</div>
			<p class="help-block">Enter the class, with namespace, that you want to use instead of the default resource.</p>
		</div>
	</div>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#page-content" data-toggle="tab">Page Content</a></li>
		<li><a href="#page-nav" data-toggle="tab">Navigation</a></li>
	</ul>
{!! Form::close() !!}