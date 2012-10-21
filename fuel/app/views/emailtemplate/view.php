<h2>Viewing #<?php echo $emailtemplate->id; ?></h2>

<p>
	<strong>Subject:</strong>
	<?php echo $emailtemplate->subject; ?></p>
<p>
	<strong>Tag:</strong>
	<?php echo $emailtemplate->tag; ?></p>
<p>
	<strong>Body:</strong>
	<?php echo $emailtemplate->body; ?></p>

<?php echo Html::anchor('emailtemplate/edit/'.$emailtemplate->id, 'Edit'); ?> |
<?php echo Html::anchor('emailtemplate', 'Back'); ?>