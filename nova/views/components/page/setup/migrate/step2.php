<p>Nova gives you the ability to upgrade only the items you want. Using the list below, please select which items you want Nova to upgrade.</p>

<?php echo Form::open('setup/upgrade/index/3');?>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>Items to Upgrade</th>
				<th class="span1 align-center">Status</th>
				<th class="span1 align-center">Yes</th>
				<th class="span1 align-center">No</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					Characters &amp; Users
					<p class="alert alert-danger hidden"><span class="errors-content"></span></p>
				</td>
				<td class="span1 align-center align-middle align-middle">
					<span class="success hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_characters_users', 1, array('checked' => true));?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_characters_users', 0);?></td>
			</tr>
			<tr>
				<td>
					Awards
					<p class="alert alert-danger hidden"><span class="errors-content"></span></p>
				</td>
				<td class="span1 align-center align-middle">
					<span class="success hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_awards', 1, array('checked' => true));?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_awards', 0);?></td>
			</tr>
			<tr>
				<td>
					System Settings, Messages &amp; Bans
					<p class="alert alert-danger hidden"><span class="errors-content"></span></p>
				</td>
				<td class="span1 align-center align-middle">
					<span class="success hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_settings', 1, array('checked' => true));?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_settings', 0);?></td>
			</tr>
			<tr>
				<td>
					Personal Logs
					<p class="alert alert-danger hidden"><span class="errors-content"></span></p>
				</td>
				<td class="span1 align-center align-middle">
					<span class="success hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_logs', 1, array('checked' => true));?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_logs', 0);?></td>
			</tr>
			<tr>
				<td>
					News
					<p class="alert alert-danger hidden"><span class="errors-content"></span></p>
				</td>
				<td class="span1 align-center align-middle">
					<span class="success hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_news', 1, array('checked' => true));?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_news', 0);?></td>
			</tr>
			<tr>
				<td>
					Missions &amp; Posts
					<p class="alert alert-danger hidden"><span class="errors-content"></span></p>
				</td>
				<td class="span1 align-center align-middle">
					<span class="success hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_missions', 1, array('checked' => true));?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_missions', 0);?></td>
			</tr>
			<tr>
				<td>
					Specifications
					<p class="alert alert-danger hidden"><span class="errors-content"></span></p>
				</td>
				<td class="span1 align-center align-middle">
					<span class="success hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_specs', 1, array('checked' => true));?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_specs', 0);?></td>
			</tr>
			<tr>
				<td>
					Tour Items
					<p class="alert alert-danger hidden"><span class="errors-content"></span></p>
				</td>
				<td class="span1 align-center align-middle">
					<span class="success hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_tour', 1, array('checked' => true));?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_tour', 0);?></td>
			</tr>
			<tr>
				<td>
					Wiki Pages
					<p class="alert alert-danger hidden"><span class="errors-content"></span></p>
				</td>
				<td class="span1 align-center align-middle">
					<span class="success hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_wiki', 1, array('checked' => true));?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_wiki', 0);?></td>
			</tr>
			<tr>
				<td>
					Uploads
					<p class="alert alert-danger hidden"><span class="errors-content"></span></p>
				</td>
				<td class="span1 align-center align-middle">
					<span class="success hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_uploads', 1, array('checked' => true));?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_uploads', 0);?></td>
			</tr>
			<tr>
				<td>
					Private Messages
					<p class="alert alert-danger hidden"><span class="errors-content"></span></p>
				</td>
				<td class="span1 align-center align-middle">
					<span class="success hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/tick-circle.png');?></span>
					<span class="failure hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation-red.png');?></span>
					<span class="warning hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/exclamation.png');?></span>
					<span class="loading hidden"><?php echo HTML::img('nova/modules/setup/views/design/images/loading.gif');?></span>
				</td>
				<td class="align-center"><?php echo Form::radio('upgrade_pm', 1, array('checked' => true));?></td>
				<td class="align-center"><?php echo Form::radio('upgrade_pm', 0);?></td>
			</tr>
		</tbody>
	</table>