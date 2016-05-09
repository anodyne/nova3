<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.menus') }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Menus</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.menus') }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Menus</span></a>
			</div>
		</div>
	</desktop>

	{!! Form::model($menu, ['route' => ['admin.menus.update', $menu->id], 'method' => 'put', 'class' => 'form-horizontal']) !!}
		<div class="form-group{{ ($errors->has('name')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Name</label>
			<div class="col-md-5">
				{!! Form::text('name', null, ['class' => 'form-control input-lg', 'v-model' => 'name']) !!}
				{!! $errors->first('name', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group{{ ($errors->has('key')) ? ' has-error' : '' }}">
			<label class="col-md-2 control-label">Key</label>
			<div class="col-md-3">
				{!! Form::text('key', null, ['class' => 'form-control input-lg', 'v-model' => 'key', '@change' => 'checkKey']) !!}
				{!! $errors->first('key', '<p class="help-block">:message</p>') !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-5 col-md-offset-2">
				<mobile>
					<p>{!! Form::button("Update Menu", ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
				</mobile>
				<desktop>
					<div class="btn-toolbar">
						<div class="btn-group">
							{!! Form::button("Update Menu", ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}
						</div>
					</div>
				</desktop>
			</div>
		</div>
	{!! Form::close() !!}
</div>