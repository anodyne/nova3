@if (Request::segment(3) === null)
	<span class="icn icn32 step tip-below" data-title="Step 1" data-icon="1"></span>
	<span class="icn icn32 step tip-below" data-title="Step 2" data-icon="1"></span>
	<span class="icn icn32 step tip-below" data-title="Step 3" data-icon="1"></span>
@endif

@if (Request::segment(3) == 'one')
	<span class="icn icn32 step step-active tip-below" data-title="Step 1" data-icon="1"></span>
	<span class="icn icn32 step tip-below" data-title="Step 2" data-icon="1"></span>
	<span class="icn icn32 step tip-below" data-title="Step 3" data-icon="1"></span>
@endif

@if (Request::segment(3) == 'two')
	<span class="icn icn32 step step-complete tip-below" data-title="Step 1" data-icon="2"></span>
	<span class="icn icn32 step step-active tip-below" data-title="Step 2" data-icon="1"></span>
	<span class="icn icn32 step tip-below" data-title="Step 3" data-icon="1"></span>
@endif

@if (Request::segment(3) == 'three')
	<span class="icn icn32 step step-complete tip-below" data-title="Step 1" data-icon="2"></span>
	<span class="icn icn32 step step-complete tip-below" data-title="Step 2" data-icon="2"></span>
	<span class="icn icn32 step step-active tip-below" data-title="Step 3" data-icon="1"></span>
@endif

@if (Uri::segment(4) == 'four')
	<span class="icn icn32 step step-complete tip-below" data-title="Step 1" data-icon="2"></span>
	<span class="icn icn32 step step-complete tip-below" data-title="Step 2" data-icon="2"></span>
	<span class="icn icn32 step step-complete tip-below" data-title="Step 3" data-icon="2"></span>
@endif