<h2>Viewing #<?php echo $actionstep->id; ?></h2>

<p>
	<strong>Title:</strong>
	<?php echo $actionstep->title; ?></p>
<p>
	<strong>Note:</strong>
	<?php echo $actionstep->note; ?></p>
<p>
	<strong>Boat share id:</strong>
	<?php echo $actionstep->boat_share_id; ?></p>
<p>
	<strong>Buyer id:</strong>
	<?php echo $actionstep->buyer_id; ?></p>

<?php echo Html::anchor('actionstep/edit/'.$actionstep->id, 'Edit'); ?> |
<?php echo Html::anchor('actionstep', 'Back'); ?>