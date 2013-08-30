@if (Request::segment(3) === null)
	<span class="icn icn32 step tip-below" data-title="Step 1" data-icon="1"></span>
@endif

@if (Request::segment(3) == 'finalize')
	<span class="icn icn32 step step-complete tip-below" data-title="Step 1" data-icon="2"></span>
@endif