<div class="page-header">
	<h1>Form Preview <small>{!! $form->present()->name !!}</small></h1>
</div>

<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.forms') }}" class="btn btn-default btn-lg btn-block">Back to Forms</a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.forms') }}" class="btn btn-default">Back to Forms</a>
			</div>
		</div>
	</desktop>
</div>

{!! $form->present()->renderNewForm(false, false) !!}