<div class="alert alert-block{{ (isset($class)) ? ' '.$class : '' }} fade in">
	{{ (isset($heading)) ? '<h4>'.$heading.'</h4>' : '' }}
	<p>{{ $content }}</p>
</div>