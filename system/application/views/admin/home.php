<?php echo format_messages($messages, $message_type); ?>
<div class="content_left">
	<?php if ($option['status']): ?>
	<h2><?php echo e('admin_home_left_label_too'); ?></h2>
	<?php echo form_open('admin/do_regenerate'); ?>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<tr>
			<td align="right">
				<label for="username"><?php echo ($settings['password_pin_generation'] == 'email') ? e('admin_home_email') : e('admin_home_username'); ?>:</label>
			</td>
			<td>
				<?php echo form_input(array('id'=>'username', 'name'=>'username', 'value'=>'', 'maxlength'=>63, 'class'=>'text')); ?>
			</td>
		</tr>
		<?php if ($settings['pin']): ?>
		<tr>
			<td align="right">
			</td>
			<td>
				<label for="pin"><?php echo form_checkbox(array('id'=>'pin', 'name'=>'pin', 'value'=>TRUE, 'checked'=>FALSE)); ?> <?php echo e('admin_home_pin'); ?></label>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td colspan="2" align="center">
				<?php echo form_submit(array('name'=>'submit', 'value'=>e('admin_home_submit_too'))); ?>
			</td>
		</tr>
	</table>
	<?php echo form_close(); ?>
	<?php else: ?>
	<h2><?php echo e('admin_home_left_label'); ?></h2>
	<div class="notes">
		<h2><?php echo e('admin_home_manage_question'); ?></h2>
		<ul>
			<li><?php echo anchor('admin/candidates', e('admin_home_manage_candidates')); ?></li>
			<li><?php echo anchor('admin/parties', e('admin_home_manage_parties')); ?></li>
			<li><?php echo anchor('admin/positions', e('admin_home_manage_positions')); ?></li>
			<li><?php echo anchor('admin/voters', e('admin_home_manage_voters')); ?></li>
		</ul>
	</div>
	<?php endif; ?>
</div>
<div class="content_right">
	<h2><?php echo e('admin_home_right_label'); ?></h2>
	<?php echo form_open('admin/do_edit_option/1'); ?>
	<table cellpadding="0" cellspacing="0" border="0" class="form_table">
		<tr>
			<td align="right">
				<?php echo e('admin_home_status'); ?>:
			</td>
			<td>
				<?php if ($settings['realtime_results']): ?>
				<label><?php echo form_radio(array('name'=>'status', 'class'=>'changeElectionStatus', 'value'=>1, 'checked'=>(($option['status']) ? TRUE : FALSE))); ?> <?php echo e('admin_home_running'); ?></label>
				<?php else: ?>
				<label><?php echo form_radio(array('name'=>'status', 'class'=>'changeElectionStatus', 'value'=>1, 'checked'=>(($option['status']) ? TRUE : FALSE))); ?> <?php echo e('admin_home_running'); ?></label>
				<?php endif; ?>
			</td>
			<td>
				<?php if ($settings['realtime_results']): ?>
				<label><?php echo form_radio(array('name'=>'status', 'class'=>'changeElectionStatus', 'value'=>0, 'checked'=>(($option['status']) ? FALSE : TRUE))); ?> <?php echo e('admin_home_not_running'); ?></label>
				<?php else: ?>
				<label><?php echo form_radio(array('name'=>'status', 'class'=>'changeElectionStatus', 'value'=>0, 'checked'=>(($option['status']) ? FALSE : TRUE))); ?> <?php echo e('admin_home_not_running'); ?></label>
				<?php endif; ?>
			</td>
		</tr>
		<tr class="results">
			<td align="right">
				<?php echo e('admin_home_results'); ?>:
			</td>
			<td colspan="2">
				<label><?php echo form_checkbox(array('name'=>'result', 'value'=>1, 'checked'=>(($option['result']) ? TRUE : FALSE))); ?> <?php echo e('admin_home_publish'); ?></label>
			</td>
		</tr>
		<?php if ($settings['realtime_results']): ?>
		<tr>
			<td align="right">
				&nbsp;
			</td>
			<td colspan="2">
				&nbsp;&nbsp;&nbsp;<?php echo anchor('gate/results', e('admin_home_realtime')); ?>
			</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td colspan="3" align="center">
				<?php echo form_submit(array('name'=>'submit', 'value'=>e('admin_home_submit'))); ?>
			</td>
		</tr>
	</table>
	<?php echo form_close(); ?>
</div>
<div style="clear:both;"></div>
