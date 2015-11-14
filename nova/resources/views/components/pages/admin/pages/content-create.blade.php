<div v-cloak>
	<phone-tablet>
		<p><a href="{{ route('admin.content') }}" class="btn btn-default btn-lg btn-block">Back to Page Content Manager</a></p>
	</phone-tablet>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.content') }}" class="btn btn-default">Back to Page Content Manager</a>
			</div>
		</div>
	</desktop>
</div>

{!! Form::open(['route' => 'admin.content.store', 'class' => 'form-horizontal']) !!}
	<div class="form-group">
		<label class="col-md-2 control-label">Page</label>
		<div class="col-md-5">
			{!! Form::select('page_id', $pages, null, ['class' => 'form-control input-lg']) !!}
		</div>
	</div>

	<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
		<label class="col-md-2 control-label">Key</label>
		<div class="col-md-6">
			{!! Form::text('key', null, ['class' => 'form-control input-lg']) !!}
			{!! $errors->first('key', '<p class="help-block">:message</p>') !!}
			<p class="help-block">Keys are used to uniquely identify your page content and pull that content out of the database. The only restriction with keys is that they <strong>cannot</strong> have the same key as another page.</p>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-2 control-label">Value</label>
		<div class="col-md-8">
			{!! Form::textarea('value', null, ['class' => 'form-control input-lg', 'rows' => 5]) !!}

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

	{!! Form::hidden('type', 'other') !!}

	<div class="col-md-5 col-md-offset-2" v-cloak>
		<phone-tablet>
			{!! Form::button("Add Page Content", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}
		</phone-tablet>
		<desktop>
			{!! Form::button("Add Page Content", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
		</desktop>
	</div>
{!! Form::close() !!}