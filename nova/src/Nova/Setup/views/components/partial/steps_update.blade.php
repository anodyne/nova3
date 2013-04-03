@if (Request::segment(3) === null)
	<span class="icn icn24 step tip-below" data-title="Step 1" data-icon="n"></span>
@endif

@if (Request::segment(3) == 'finalize')
	<span class="icn icn24 step step-complete tip-below" data-title="Step 1" data-icon="c"></span>
@endif