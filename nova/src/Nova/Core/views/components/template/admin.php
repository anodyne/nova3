<noscript>
	<div class="alert system-warning"><div class="container"><?php echo lang('short.javascript');?></div></div>
</noscript>

<?php echo $navmain;?>

<div class="container">
	<div class="content">
		<div class="page-header">
			<h1><?php echo $header;?></h1>
		</div>
		<div><?php echo $message;?></div>
		
		<?php echo $flash;?>
		<?php echo $content;?>
		<?php echo $ajax;?>
		
		<div style="clear:both;">&nbsp;</div>
	</div>
</div>

<div class="container">
	<footer>
		<?php echo $footer;?>
	</footer>
</div>