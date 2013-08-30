<?php //if (Auth::is_logged_in()): ?>
	<!-- USER PANEL -->
	<div id="panel">
		<div class="panel-body">
			<div class="wrapper">
				<table class="table100">
					<tbody>
						<tr>
							<td class="panel_1 align_top"><?php echo $panel1;?></td>
							<td class="panel_spacer"></td>
							<td class="panel_2 align_top"><?php echo $panel2;?></td>
							<td class="panel_spacer"></td>
							<td class="panel_3 align_top"><?php echo $panel3;?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="panel-handle UITheme">
			<div class="wrapper">
				<?php echo $workflow;?>
			</div>
		</div>
	</div>
<?php //endif; ?>