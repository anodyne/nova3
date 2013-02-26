<?php if (Uri::segment(4) == 0): ?>
	<span class="icn icn24 step tip-below" data-title="Step 1" data-icon="n"></span>
	<span class="icn icn24 step tip-below" data-title="Step 2" data-icon="n"></span>
	<span class="icn icn24 step tip-below" data-title="Step 3" data-icon="n"></span>
<?php endif;?>

<?php if (Uri::segment(4) == 1): ?>
	<span class="icn icn24 step step-active tip-below" data-title="Step 1" data-icon="s"></span>
	<span class="icn icn24 step tip-below" data-title="Step 2" data-icon="n"></span>
	<span class="icn icn24 step tip-below" data-title="Step 3" data-icon="n"></span>
<?php endif;?>

<?php if (Uri::segment(4) == 2): ?>
	<span class="icn icn24 step step-complete tip-below" data-title="Step 1" data-icon="c"></span>
	<span class="icn icn24 step step-active tip-below" data-title="Step 2" data-icon="s"></span>
	<span class="icn icn24 step tip-below" data-title="Step 3" data-icon="n"></span>
<?php endif;?>

<?php if (Uri::segment(4) == 3): ?>
	<span class="icn icn24 step step-complete tip-below" data-title="Step 1" data-icon="c"></span>
	<span class="icn icn24 step step-complete tip-below" data-title="Step 2" data-icon="c"></span>
	<span class="icn icn24 step step-active tip-below" data-title="Step 3" data-icon="s"></span>
<?php endif;?>

<?php if (Uri::segment(4) == 4): ?>
	<span class="icn icn24 step step-complete tip-below" data-title="Step 1" data-icon="c"></span>
	<span class="icn icn24 step step-complete tip-below" data-title="Step 2" data-icon="c"></span>
	<span class="icn icn24 step step-complete tip-below" data-title="Step 3" data-icon="c"></span>
<?php endif;?>