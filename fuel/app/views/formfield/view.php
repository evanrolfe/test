<h2>Viewing #<?php echo $formfield->id; ?></h2>

<p>
	<strong>Key:</strong>
	<?php echo $formfield->key; ?></p>
<p>
	<strong>Value:</strong>
	<?php echo $formfield->value; ?></p>
<p>
	<strong>Type:</strong>
	<?php echo $formfield->type; ?></p>
<p>
	<strong>Required:</strong>
	<?php echo $formfield->required; ?></p>

<?php echo Html::anchor('formfield/edit/'.$formfield->id, 'Edit'); ?> |
<?php echo Html::anchor('formfield', 'Back'); ?>