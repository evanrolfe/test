
<div class="widget fluid">
    <div class="whead">
		<div>
			<h6>This yachtshare has been sold!</h6>
		</div>
		<div class="clear"></div>
	</div>

    <div class="formRow">
		<div>
			<a href="<?=Uri::create('data/print/invoice/'.$yachtshare->id);?>" class="buttonS bBlue" style="margin: 6px 6px; color: white;">Invoice</a>
			<a href="<?=Uri::create('data/print/letter_buyer/'.$yachtshare->id);?>" class="buttonS bBlue" style="margin: 6px 6px; color: white;">Buyer Letter</a>
			<a href="<?=Uri::create('data/print/letter_seller/'.$yachtshare->id);?>" class="buttonS bBlue" style="margin: 6px 6px; color: white;">Seller Letter</a>
		</div>
		<div class="clear"></div>
	</div>
</div>
