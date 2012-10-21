<h2>Editing Share</h2>
<br>

<?php echo render('share/_form'); ?>
<p>
	<?php echo Html::anchor('share/view/'.$share->id, 'View'); ?> |
	<?php echo Html::anchor('share', 'Back'); ?></p>
