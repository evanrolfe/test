<?= render('boat/_nav', array('boat' => $boat)); ?>
</div>

<div class="widget">

    <div class="whead">
		<div>
			<h6>Shares for boat:</h6> <h6><?= $boat->name; ?></h6>
		</div>
		<div style='text-align: right'>
			<a href="<?= Uri::create('share/create'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;"><span class="icon-add"></span><span>New</span></button></a>
		</div>
		<div class="clear"></div>
	</div>

	<?= render('share/_table', array('shares' => $boat->shares, 'available_actionsteps' => $available_actionsteps)); ?>		
</div>
