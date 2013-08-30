<div class="alert{{ (isset($class)) ? ' '.$class : ' alert-warning' }} fade in">
	{{ (isset($heading)) ? '<h4>'.$heading.'</h4>' : '' }}
	<p>{{ $content }}</p>
</div>