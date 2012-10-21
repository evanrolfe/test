<h2>Viewing #<?php echo $share->id; ?></h2>

<p>
	<strong>Boat id:</strong>
	<?php echo $share->boat_id; ?></p>
<p>
	<strong>Buyer id:</strong>
	<?php echo $share->buyer_id; ?></p>
<p>
	<strong>Fraction:</strong>
	<?php echo $share->fraction; ?></p>

<?php echo Html::anchor('share/edit/'.$share->id, 'Edit'); ?> |
<?php echo Html::anchor('share', 'Back'); ?>