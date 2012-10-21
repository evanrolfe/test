<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>Yacht Fractions</title>
	<?php echo render('_includes'); ?>
</head>
<body>
<?php echo render('_flash_messages'); ?>
<script type="text/javascript">
$(document).ready(function(){
	$("#create_form").validate({
		rules : {
			password2 : { equalTo : "#password"}
		},
		messages : {
			password2 : "This password must match the one in the previous field."
		}
	});
});
</script>

<form action="<?= Uri::create('seller/create'); ?>" method="POST" accept-charset="utf-8" id="create_form">
<div style="width: 100%;" align="center">
<div class="widget fluid" style="width: 450px;">

    <div class="whead">
		<h6>Seller Registration</h6>
		<div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>Name:</label></div>
        <div class="grid9" align="right"><input type='text' name='name' class='required'/></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Email:</label></div>
        <div class="grid9" align="right"><input type='text' name='email' class="required email"/></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Password:</label></div>
        <div class="grid9" align="right"><input type='password' name='password' id='password' class='required'/></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3" align="left"><label>Repeat Password:</label></div>
        <div class="grid9" align="right"><input type='password' name='password2' id='password2' class='required'/></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Boat name:</label></div>
        <div class="grid9" align="right"><input type='text' name='boat_name'  class='required' /></div>
        <div class="clear"></div>
    </div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Register</button>
		</div>
		<div class="clear"></div>
	</div>

</div>
<a href="<? Uri::create('session/logout'); ?>">Logout</a>
</div>
</form>
