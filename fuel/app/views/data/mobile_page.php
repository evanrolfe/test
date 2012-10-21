<?= render('settings/_nav'); ?>

<form action="<?= Uri::create('mobile'); ?>" method="POST" enctype="multipart/form-data">

<div class="widget fluid">
    <div class="whead">
		<h6>Send Data Email</h6>
		<div class="clear"></div>
	</div>

	<div class="formRow">
			Click on send to send an email to your mobile containing all data for buyers and sellers.
		 <div class="clear"></div>
	</div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Send</button>
		</div>
		<div class="clear"></div>
	</div>
</div>
</form>
