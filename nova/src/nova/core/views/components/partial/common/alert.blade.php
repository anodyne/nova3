<div class="alert alert-block{{ (isset($class)) ? ' '.$class : '' }} fade in">
	<a class="close" data-dismiss="alert" href="#">&times;</a>
	{{ (isset($heading)) ? '<h4>'.$heading.'</h4>' : '' }}
	<p>{{ $content }}</p>
</div>