<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/user/edit/'.$user->id) }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>

	<div class="btn-group">
		<a href="{{ URL::to('admin/user/upload/'.$user->id) }}" class="btn btn-default tooltip-top icn-size-16" title="{{ langConcat('Action.upload New Image') }}">{{ $_icons['upload'] }}</a>
	</div>
</div>

<div>{{ HTML::image('app/assets/images/users/'.$user->getMedia()->filename, false, ['id' => 'jcrop']) }}</div>

<div id="preview-pane">
	<div class="preview-container">
		{{ HTML::image('app/assets/images/users/'.$user->getMedia()->filename, false, ['class' => 'jcrop-preview']) }}
	</div>
</div>

<p><a href="#" class="btn btn-primary">Crop</a></p>