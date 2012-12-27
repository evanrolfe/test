<?= render('settings/_nav'); ?>

<div class="widget">
    <div class="whead">
		<h6>Data</h6>
		<div style='text-align: right'>
		<? if($offline): ?>
			<a href="<?= Uri::create('data/import'); ?>" class="buttonS bBlue" style="margin: 6px 6px;" ><span class="icon-upload"></span><span>Import</span></a>
		<? endif; ?>
		</div>
		<div class="clear"></div>
	</div>

	<? if(!$offline): ?>
	<div class="formRow">

			To export, right click on the "Export" link below and click "Save link as" then choose the folder in which you want to save the backup file.
			<br>
			<a href="<?= Uri::create('data/export'); ?>">Export</button></a><br>
		<div class="clear"></div>
	</div>
	<? endif; ?>

	<div class="formRow">
		<div class="grid3">
			Previous imports/exports:
		</div>
		<div class="grid9">
		<? foreach($backups as $backup): ?>
			<?= $backup->type; ?> at <?= Date::forge($backup->created_at)->format("%d/%m/%Y - %H:%m"); ?><br>
		<? endforeach; ?>
		</div>
		<div class="clear"></div>
	</div>
</div>
