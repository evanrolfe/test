<div class="widget">
	<div class="whead">
		<div>
			<h6>Filter Yacht Shares</h6>
		</div>

<div style='text-align: right;'>
		<a href="<?= Uri::create('share'); ?>"><button class="buttonS bGreen" style="margin: 6px 6px;" type="button">Filter</button></a>
		</div>

		<div class="clear"></div>
	</div>

	<div class="fluid formRow">
		<div class="grid3">		
			Has a sale in progress<br>
			
		</div>
		<div class="grid3">		
			UK Based<br>
			Overseas<br>
		</div>
	</div>
</div>

<div class="widget">
 <div class="whead">
		<div>
			<h6>Listing Yacht Shares</h6>
		</div>
		<div style='text-align: right'>
			<a href="<?= Uri::create('share/create'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;"><span class="icon-add"></span><span>New</span></button></a>
		</div>
		<div class="clear"></div>
	</div>


	<?= render('share/_table', array('shares' => $shares, 'available_actionsteps' => $available_actionsteps)); ?>
</div>
