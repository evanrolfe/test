<div class="widget fluid" style="width: 75%;">
    <div class="whead">
		<h6>Enquiry Successful</h6>
		<div align="right">
			<a href="http://www.yachtfractions.co.uk/" class="buttonS bBlue" style="margin: 6px 6px;">Done</a>
		</div>
		<div class="clear"></div>
	</div>

    <div class="formRow">
Thank you for registering your interest with Yachtfractions. We have recorded the following information and will be in contact shortly.
        <div class="clear"></div>
    </div>
</div>

<div class="widget fluid" style="width: 75%;">
    <div class="whead">
		<h6>Data Entered:</h6>
		<div class="clear"></div>
	</div>

    <div class="formRow">
    	<div class="grid3"><label>Name:</label></div>
        <div class="grid9" align="right"><?= $buyer->name; ?></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
    	<div class="grid3"><label>Email:</label></div>
        <div class="grid9" align="right"><?= $buyer->email; ?></div>
        <div class="clear"></div>
    </div>

	<? foreach($buyer->preferences as $key => $value): ?>
	<? if(in_array($key, array("max_share_size_den", "max_share_size_num", "min_share_size_den", "min_share_size_num", "boats_interest", "interested", "max_share_size_fraction", "min_share_size_fraction"))){ continue; } ?>
    <div class="formRow">
    	<div class="grid3"><label><?= $fields[$key]; ?></label></div>
        <div class="grid9" align="right">

			<? if($key == 'max_share_size' || $key == 'min_share_size'): ?>
				<?= $buyer->preferences[$key.'_fraction']; ?>
			<? else: ?>
				<?= $value; ?>
			<? endif; ?>

		</div>
        <div class="clear"></div>
    </div>
	<? endforeach; ?>
</div>
