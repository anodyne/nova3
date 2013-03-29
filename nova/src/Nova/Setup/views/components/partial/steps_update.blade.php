@if (Request::segment(3) === null)
	<span class="icn icn24 step tip-below" data-title="Step 1" data-icon="n"></span>
	<span class="icn icn24 step tip-below" data-title="Step 2" data-icon="n"></span>
@endif

@if (Request::segment(3) == 'one')
	<span class="icn icn24 step step-complete tip-below" data-title="Step 1" data-icon="c"></span>
	<span class="icn icn24 step step-active tip-below" data-title="Step 2" data-icon="s"></span>
@endif

@if (Request::segment(3) == 'two')
	<span class="icn icn24 step step-complete tip-below" data-title="Step 1" data-icon="c"></span>
	<span class="icn icn24 step step-complete tip-below" data-title="Step 2" data-icon="c"></span>
@endif