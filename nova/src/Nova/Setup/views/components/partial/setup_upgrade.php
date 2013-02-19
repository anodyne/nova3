<?php if (Uri::segment(4) == 0): ?>
	<!-- step 3 -->
	<div class="step"></div>
	
	<!-- step 2 -->
	<div class="step"></div>
	
	<!-- step 1 -->
	<div class="step"></div>
<?php endif;?>

<?php if (Uri::segment(4) == 1): ?>
	<!-- step 3 -->
	<div class="step"></div>
	
	<!-- step 2 -->
	<div class="step"></div>
	
	<!-- step 1 -->
	<div class="step step-active"></div>
<?php endif;?>

<?php if (Uri::segment(4) == 2): ?>
	<!-- step 3 -->
	<div class="step"></div>
	
	<!-- step 2 -->
	<div class="step step-active"></div>
	
	<!-- step 1 -->
	<div class="step step-complete"></div>
<?php endif;?>

<?php if (Uri::segment(4) == 3): ?>
	<!-- step 3 -->
	<div class="step step-active"></div>
	
	<!-- step 2 -->
	<div class="step step-complete"></div>
	
	<!-- step 1 -->
	<div class="step step-complete"></div>
<?php endif;?>

<?php if (Uri::segment(4) == 4): ?>
	<!-- step 3 -->
	<div class="step step-complete"></div>
	
	<!-- step 2 -->
	<div class="step step-complete"></div>
	
	<!-- step 1 -->
	<div class="step step-complete"></div>
<?php endif;?>