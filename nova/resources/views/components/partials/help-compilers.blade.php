<p>Page compilers are an easy way to make your pages more dynamic by injecting content from the database and other resources into your page content before it gets displayed in the browser. Below are the different page compilers available and how to use them.</p>

<ul>
@foreach (app('nova.page.compiler')->getCompilers() as $compiler)
	<li>{!! Markdown::parse($compiler->help()) !!}</li>
@endforeach
</ul>