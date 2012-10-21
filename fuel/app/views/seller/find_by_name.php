<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>Yacht Fractions</title>
	<?php echo render('_includes'); ?>
</head>
<body>
<?php echo render('_flash_messages'); ?>
<form action="<?= Uri::create('seller/search'); ?>" method="POST" accept-charset="utf-8">
<div style="width: 100%;" align="center">
<div class="widget fluid" style="width: 450px;" id="search_form">
    <div class="whead">
		<div>
			<h6>Search Yacht Shares</h6>
		</div>
		<div style='text-align: right'>
			<button class="buttonS bRed" style="margin: 6px 6px;" onclick="$('#search_form').hide();$('#new_share').show();"><span>Back</span></button>
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
<a href="<? Uri::create('session/logout'); ?>">Logout</a>
</div>
