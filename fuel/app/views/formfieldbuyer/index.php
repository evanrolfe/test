<?= render('settings/_nav'); ?>

<div class="widget">
    <div class="whead">
		<h6>Buyer Enquiry Fields</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('formfieldbuyer/order/buyer'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button">Change Order</button></a>
			<a href="<?= Uri::create('formfieldbuyer/create/buyer'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button"><span class="icon-add"></span>New</button></a>
		</div>
		<div class="clear"></div>
	</div>

<?= render('formfieldbuyer/_table', array('fields' => $buyer_fields)); ?>
</div>

<div class="widget">
    <div class="whead">
		<h6>Yachtshare Fields</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('formfieldbuyer/order/seller'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button">Change Order</button></a>
			<a href="<?= Uri::create('formfieldbuyer/create/seller'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button"><span class="icon-add"></span>New</button></a>
		</div>
		<div class="clear"></div>
	</div>

<?= render('formfieldbuyer/_table', array('fields' => $seller_fields)); ?>
</div>
