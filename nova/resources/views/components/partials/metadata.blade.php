@foreach ($metadata as $name => $content)
	{{ HTML::meta($name, $content) }}
@endforeach