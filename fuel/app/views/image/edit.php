<h2>Editing Image</h2>
<br>

<?php echo render('image/_form'); ?>
<p>
	<?php echo Html::anchor('image/view/'.$image->id, 'View'); ?> |
	<?php echo Html::anchor('image', 'Back'); ?></p>
