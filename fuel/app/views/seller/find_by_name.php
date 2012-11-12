<form action="<?= Uri::create('seller/search'); ?>" method="POST" accept-charset="utf-8">
<div class="widget fluid" style="width: 450px;" id="search_form">
    <div class="whead">
		<div>
			<h6>Search Yacht Shares</h6>
		</div>
		<div style='text-align: right'>
			<a href="<?=Uri::create('seller');?>"><button class="buttonS bRed" style="margin: 6px 6px;" type="button"><span>Back</span></button></a>
		</div>
		<div class="clear"></div>
	</div>

	<div class="formRow">
        <div class="grid3"><label>Name:</label></div>
        <div class="grid9"><input type='text' name='boat_name' /></div>
		<div class="clear"></div>
	</div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bBlue" style="margin: 6px 6px;" type="submit">Find Yacht Shares</button>
		</div>
		<div class="clear"></div>
	</div>
</form>
</div>
