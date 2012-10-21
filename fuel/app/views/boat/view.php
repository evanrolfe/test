
<?= render('boat/_nav', array('boat' => $boat)); ?>
	<? //= render('image/_row', array('images' => $boat->images)); ?>

	<? if(sizeof($fields) > 0): ?>
	<? foreach($fields as $key => $value): ?>
    <div class="formRow">
        <div class="grid3"><label><b><?= $key; ?>:</b></label></div>
        <div class="grid9"><?= $value; ?></div>
        <div class="clear"></div>
    </div>
	<? endforeach; ?>
	<? endif; ?>
</div>
