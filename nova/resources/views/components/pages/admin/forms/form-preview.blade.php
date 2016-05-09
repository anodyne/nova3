<div class="page-header">
	<h1>Form Preview <small>{!! $form->present()->name !!}</small></h1>
</div>

<div v-cloak>
	<mobile>
		<p><a href="{{ route('admin.forms') }}" class="btn btn-default btn-lg btn-block">{!! icon('arrow-back') !!}<span>Back to Forms</span></a></p>
	</mobile>
	<desktop>
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="{{ route('admin.forms') }}" class="btn btn-default">{!! icon('arrow-back') !!}<span>Back to Forms</span></a>
			</div>
		</div>
	</desktop>
</div>

{!! $form->present()->renderNewForm(false, false) !!}