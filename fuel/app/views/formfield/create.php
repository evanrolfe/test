<?= render('settings/_nav'); ?>

<form action="<?= Uri::create('formfield/create'); ?>" method="POST" accept-charset="utf-8">
<div class="widget fluid">

    <div class="whead">
		<h6>New Proforma Field</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('formfield'); ?>"><button class="buttonS bRed" style="margin: 6px 6px;"><span class="icon-list-2"></span><span>All Formfields</span></button></a>
		</div>
		<div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>Name:</label></div>
        <div class="grid9"><input type='text' name='key' /></div>
        <div class="clear"></div>
    </div>

    <div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Save</button>
		</div>
		<div class="clear"></div>
    </div>

</div>
</form>
