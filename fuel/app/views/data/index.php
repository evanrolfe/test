<?= render('settings/_nav'); ?>

<div class="widget">
    <div class="whead">
		<h6>Data</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('data/import'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button"><span class="icon-upload"></span><span>Import</span></button></a>
			<a href="<?= Uri::create('data/export'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button"><span class="icon-download"></span><span>Export</span></button></a>
		</div>
		<div class="clear"></div>
	</div>

	<div class="formRow">
		<? foreach($backups as $backup): ?>
			<?= $backup->type; ?> at <?= Date::forge($backup->created_at)->format("%d/%m/%Y - %H:%m"); ?><br>
		<? endforeach; ?>
		<div class="clear"></div>
	</div>
</div>
