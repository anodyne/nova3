<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.content') }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Content Manager</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.content') }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Content Manager</span></a>
			</div>
		</div>
	</desktop>

	{!! Form::model($content, ['route' => ['admin.content.update', $content->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('type')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Type</label>
			<div class="col-md-3">
				{!! Form::select('type', $types, null, ['class' => 'form-control input-lg', 'placeholder' => "Choose a type", 'v-model' => 'type']) !!}
				{!! $errors->first('type', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Page</label>
			<div class="col-md-5">
				{!! Form::select('page_id', $pages, null, ['class' => 'form-control input-lg', 'v-model' => 'page']) !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Key</label>
			<div class="col-md-6">
				{!! Form::text('key', null, ['class' => 'form-control input-lg', 'v-model' => 'key', '@change' => 'checkKey']) !!}
				{!! $errors->first('key', '<p class="help-block">:message</p>') !!}
				<p class="help-block">Keys are used to uniquely identify your page content and pull that content out of the database. The only restriction with keys is that they <strong>cannot</strong> have the same key as another page.</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label">Value</label>
			<div class="col-md-8">
				{!! Form::textarea('value', null, ['class' => 'form-control input-lg', 'rows' => 5, 'v-model' => 'value']) !!}

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

		<div class="col-md-5 col-md-offset-2" v-cloak>
			<mobile>
				{!! Form::button("Update Page Content", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}
			</mobile>
			<desktop>
				{!! Form::button("Update Page Content", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
			</desktop>
		</div>
	{!! Form::close() !!}
</div>