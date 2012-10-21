<h2>Editing Formfield</h2>
<br>

<?php echo render('formfield/_form'); ?>
<p>
	<?php echo Html::anchor('formfield/view/'.$formfield->id, 'View'); ?> |
	<?php echo Html::anchor('formfield', 'Back'); ?></p>
