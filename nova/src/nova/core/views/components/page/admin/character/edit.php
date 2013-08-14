<?php

function data($obj, $i)
{
	if (is_array($obj))
	{
		return $obj[$i];
	}

	return false;
}

if (isset($characters) and Uri::segment(4) === false): ?>
	<ul class="thumbnails">
	<?php foreach ($characters as $c): ?>
		<li class="span6">
			<div class="thumbnail">
				<div class="caption">
					<div class="btn-group pull-right">
						<a href="<?php echo Uri::create('admin/character/edit/'.$c->id);?>" class="btn btn-sm"><?php echo ucfirst(lang('action.edit'));?></a>
					</div>

					<h3><?php echo $c->getName(true, true);?></h3>
				</div>
			</div>
		</li>
	<?php endforeach;?>
	</ul>
<?php else: ?>
	<div class="row">
		<div class="span3">
			Images
		</div>

		<div class="span9">
			<form class="form-<?php echo $form->orientation;?>" method="post">
				<ul class="nav nav-pills">
					<li class="active"><a href="#c-basic" data-toggle="pill" class="tooltip-top" title="<?php echo ucwords(langConcat('character info'));?>"><i class="icon-user icon-50"></i></a></li>
					<li><a href="#c-profile" data-toggle="pill" class="tooltip-top" title="<?php echo ucwords(langConcat('character bio'));?>"><i class="icon-th-list icon-50"></i></a></li>
					<li><a href="#c-images" data-toggle="pill" class="tooltip-top" title="<?php echo ucwords(langConcat('character images'));?>"><i class="icon-picture icon-50"></i></a></li>
				</ul>

				<div class="pill-content">
					<div id="c-basic" class="pill-pane active">
						<div class="row">
							<div class="span4">
								<div class="control-group">
									<label class="control-label"><?php echo ucwords(langConcat('first name'));?></label>
									<div class="controls">
										<?php echo Form::input('first_name', $character->first_name, array('class' => 'span3'));?>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label"><?php echo ucwords(langConcat('middle name'));?></label>
									<div class="controls">
										<?php echo Form::input('middle_name', $character->middle_name, array('class' => 'span3'));?>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label"><?php echo ucwords(langConcat('last name'));?></label>
									<div class="controls">
										<?php echo Form::input('last_name', $character->last_name, array('class' => 'span3'));?>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label"><?php echo ucfirst(lang('suffix'));?></label>
									<div class="controls">
										<?php echo Form::input('suffix', $character->suffix, array('class' => 'span1'));?>
									</div>
								</div>
							</div>

							<div class="span4">
								<div class="control-group">
									<label class="control-label"><?php echo ucfirst(lang('rank'));?></label>
									<div class="controls">
										<?php echo NovaForm::rank('rank_id', $character->rank_id, array('class' => 'span4 chzn'));?>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label"><?php echo ucfirst(lang('positions'));?></label>
									<div class="controls">
										<?php echo NovaForm::position('position_id', array(1,5), array('class' => 'span4 chzn', 'multiple' => 'multiple'));?>
									</div>
								</div>
							</div>
						</div>

						<div class="controls">
							<button type="submit" class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
						</div>
					</div>

					<div id="c-profile" class="pill-pane">
						<?php if ($tabs !== false): ?>
							<ul class="nav nav-tabs">
							<?php foreach ($tabs as $t): ?>
								<li><a href="#<?php echo $t->link_id;?>" data-toggle="tab"><?php echo $t->name;?></a></li>
							<?php endforeach;?>
							</ul>
							
							<div class="tab-content">
							<?php foreach ($tabs as $t): ?>
								<div class="tab-pane" id="<?php echo $t->link_id;?>">
								<?php if (is_array($sections) and array_key_exists($t->id, $sections)): ?>
									<?php foreach ($sections[$t->id] as $s): ?>
										
										<?php echo View::forge(Location::file('forms/section', $skin, 'partial'), array('s' => $s, 'fields' => $fields, 'skin' => $skin, 'data' => $data))->render();?>

									<?php endforeach;?>
								<?php endif;?>
								</div>
							<?php endforeach;?>
							</div>
						<?php else: ?>
							<?php if ($sections !== false): ?>
								<?php foreach ($sections as $s): ?>
									
									<?php echo View::forge(Location::file('forms/section', $skin, 'partial'), array('s' => $s, 'fields' => $fields, 'skin' => $skin, 'data' => $data))->render();?>

								<?php endforeach;?>
							<?php else: ?>
								<?php if ($fields !== false): ?>
									<?php foreach ($fields[$s->id] as $f): ?>
										
										<?php echo View::forge(Location::file('forms/field', $skin, 'partial'), array('f' => $f, 'data' => $data))->render();?>

									<?php endforeach;?>
								<?php endif;?>
							<?php endif;?>
						<?php endif;?>

						<div class="controls">
							<button type="submit" class="btn btn-primary"><?php echo ucfirst(lang('action.submit'));?></button>
						</div>
					</div>

					<div id="c-images" class="pill-pane">
						Images
					</div>
				</div>
			</form>
		</div>
	</div>
<?php endif;?>