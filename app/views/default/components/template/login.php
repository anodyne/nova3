<noscript>
	<div class="alert system-warning"><div class="container"><?php echo lang('short.javascript');?></div></div>
</noscript>

<div class="container">
	<div class="row">
		<div class="span6 offset3">
			<div class="page-header">
				<h1><?php echo $settings->sim_name;?></h1>
			</div>
			<h3><?php echo $header;?></h3>

			<p><?php echo $message;?></p>

			<?php echo $flash;?>
			<?php echo $content;?>
		</div>
	</div>
</div>