<h2>Editing Actionstep</h2>
<br>

<?php echo render('actionstep/_form'); ?>
<p>
	<?php echo Html::anchor('actionstep/view/'.$actionstep->id, 'View'); ?> |
	<?php echo Html::anchor('actionstep', 'Back'); ?></p>
