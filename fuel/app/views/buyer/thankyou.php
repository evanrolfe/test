<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
</head>
<?php echo render('_includes'); ?>
<?php echo render('_flash_messages'); ?>
<br>
<div style="width: 100%;" align="center"	>
<div class="widget fluid" style="width: 450px;">

    <div class="whead">
		<h6>Enquiry Successful</h6>
		<div align="right">
			<a href="http://www.yachtfractions.co.uk/"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button">Done</button></a>
		</div>
		<div class="clear"></div>
	</div>

    <div class="formRow">
Thank you for registering your interest with Yachtfractions. We have recorded the following information and will be in contact shortly.
        <div class="clear"></div>
    </div>

</div>
</div>
</form>
<div style="width: 100%;" align="center"	>
<div class="widget" style="width: 450px;">

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
	<? if(in_array($key, array("max_share_size_den", "max_share_size_num", "min_share_size_den", "min_share_size_num", "interested"))){ continue; } ?>
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
</div>
<br>
