<?= render('settings/_nav'); ?>

<form action="<?= Uri::create('data/import'); ?>" method="POST" enctype="multipart/form-data">

<div class="widget fluid">
    <div class="whead">
		<h6>Import</h6>
		<div class="clear"></div>
	</div>

	<div class="formRow">
	    <div class="grid3"><label>Select backup file:</label></div>
	    <div class="grid9" align="left">
			<input type='file' name="file"/>
		</div>
		 <div class="clear"></div>
	</div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Upload</button>
		</div>
		<div class="clear"></div>
	</div>
</div>
</form>
