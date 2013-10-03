<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/user/edit/'.$user->id) }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>

	<div class="btn-group">
		<a href="{{ URL::to('admin/user/upload/'.$user->id) }}" class="btn btn-default tooltip-top icn-size-16" title="{{ langConcat('Action.upload New Image') }}">{{ $_icons['upload'] }}</a>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		{{ HTML::image('app/assets/images/users/'.$user->getMedia()->filename, false, ['id' => 'jcrop']) }}
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		{{ Form::open(['url' => 'admin/user/avatar/'.$user->id, 'id' => 'coordinates']) }}
			{{ Form::hidden('x1', '') }}
			{{ Form::hidden('x2', '') }}
			{{ Form::hidden('y1', '') }}
			{{ Form::hidden('y2', '') }}
			{{ Form::hidden('width', '') }}
			{{ Form::hidden('height', '') }}

			{{ Form::button(lang('Action.crop'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
		{{ Form::close() }}
	</div>
</div>