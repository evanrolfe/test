<?= render('settings/_nav'); ?>

<div class="widget">
    <div class="whead">
		<h6>Data</h6>
		<div style='text-align: right'>
		<? if($offline): ?>
			<a href="<?= Uri::create('data/import'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button"><span class="icon-upload"></span><span>Import</span></button></a>
		<? endif; ?>
		</div>
		<div class="clear"></div>
	</div>

	<div class="formRow">
		<? if(!$offline): ?>
			To export, right click on the "Export" button and click "Save link as" then choose the folder in which you want to save the backup file. <a href="<?= Uri::create('data/export'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button"><span class="icon-download"></span><span>Export</span></button></a><br>
		<? endif; ?>
		<? foreach($backups as $backup): ?>
			<?= $backup->type; ?> at <?= Date::forge($backup->created_at)->format("%d/%m/%Y - %H:%m"); ?><br>
		<? endforeach; ?>
		<div class="clear"></div>
	</div>
</div>
