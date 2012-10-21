
<div class="widget fluid">
    <div class="whead">
		<div>
			<h6>This yachtshare has been sold!</h6>
		</div>
		<div class="clear"></div>
	</div>

    <div class="formRow">
		<div>
			<a href="<?=Uri::create('data/print/invoice/'.$yachtshare->id);?>"><button class="buttonS bBlue" style="margin: 6px 6px;">Invoice</button></a>
			<a href="<?=Uri::create('data/print/letter_buyer/'.$yachtshare->id);?>"><button class="buttonS bBlue" style="margin: 6px 6px;">Buyer Letter</button></a>
			<a href="<?=Uri::create('data/print/letter_seller/'.$yachtshare->id);?>"><button class="buttonS bBlue" style="margin: 6px 6px;">Seller Letter</button></a>
		</div>
		<div class="clear"></div>
	</div>
</div>
