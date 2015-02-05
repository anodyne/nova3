<h1>Edit Page <small>{{ $page->present()->name }}</small></h1>

{!! Form::model($page, ['class' => 'form-horizontal']) !!}
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">Name</label>
				<div class="col-md-8">
					{!! Form::text('name', null, ['class' => 'form-control']) !!}
					<p class="help-block">Named routes allow for changing the URI without having to worry about links breaking. Names must be unique and can't contain any special characters.</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label">HTTP Verb</label>
				<div class="col-md-8">
					{!! Form::select('verb', $httpVerbs, null, ['class' => 'form-control']) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label">Collection</label>
				<div class="col-md-8">
					{!! Form::text('verb', null, ['class' => 'form-control']) !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label class="col-md-4 control-label">URI</label>
				<div class="col-md-8">
					<div class="input-group">
						{!! Form::text('uri', null, ['class' => 'form-control']) !!}
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">Help</button>
						</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label">Default Resource</label>
				<div class="col-md-8">
					<p class="form-control-static">{{ $page->default_resource }}</p>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-4 control-label">New Resource</label>
				<div class="col-md-8">
					<div class="input-group">
						{!! Form::text('resource', null, ['class' => 'form-control']) !!}
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">Reset</button>
						</span>
					</div>
					<p class="help-block">Enter the class, with namespace, that you want to use instead of the default resource.</p>
				</div>
			</div>
		</div>
	</div>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#page-content" data-toggle="tab">Page Content</a></li>
		<li><a href="#page-nav" data-toggle="tab">Navigation</a></li>
	</ul>
{!! Form::close() !!}