<h2>Viewing #<?php echo $image->id; ?></h2>

<p>
	<strong>Boat id:</strong>
	<?php echo $image->boat_id; ?></p>

<?php echo Html::anchor('image/edit/'.$image->id, 'Edit'); ?> |
<?php echo Html::anchor('image', 'Back'); ?>