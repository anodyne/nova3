<p>{{ lang('short.admin.users.uploadSize', Media::getFileSizeLimit()) }}</p>

<div class="btn-toolbar">
	<div class="btn-group">
		<a href="{{ URL::to('admin/user/edit/'.$id) }}" class="btn btn-default icn-size-16">{{ $_icons['back'] }}</a>
	</div>
</div>

<div class="well dropzone-upload visible-lg" id="upload">
	<div class="icn-size-64 icn-opacity-25 text-center">{{ $_icons['upload'] }}</div>
	<div class="icn-size-32 text-success text-center hidden">{{ $_icons['check'] }}</div>
	<div class="icn-size-32 text-danger text-center hidden">{{ $_icons['warning'] }}</div>
</div>

<div class="row hidden" id="crop">
	<div class="col-lg-12">
		<a href="{{ URL::to('admin/user/avatar/'.$id) }}" class="btn btn-primary">{{ lang('Action.crop') }}</a>
	</div>
</div>