@if (Request::segment(3) === null)
	<span class="icn icn-size-md step tip-below" data-title="Step 1" data-icon="1"></span>
	<span class="icn icn-size-md step tip-below" data-title="Step 2" data-icon="1"></span>
@endif

@if (Request::segment(3) == 'settings')
	<span class="icn icn-size-md step tip-below" data-title="Step 1" data-icon="2"></span>
	<span class="icn icn-size-md step tip-below" data-title="Step 2" data-icon="1"></span>
@endif

@if (Request::segment(3) == 'finalize')
	<span class="icn icn-size-md step tip-below" data-title="Step 1" data-icon="2"></span>
	<span class="icn icn-size-md step tip-below" data-title="Step 2" data-icon="2"></span>
@endif