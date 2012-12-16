<script type="text/javascript">
$(document).ready(function(){
	$("#create_form").validate();
});
</script>

<form action="<?= Uri::create('seller/create'); ?>" method="POST" accept-charset="utf-8" id="create_form">

<div class="widget fluid" style="width: 650px;">

    <div class="whead">
		<h6>Seller Registration</h6>
		<div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3" align="left"><label>Your name:</label></div>
        <div class="grid9" align="right"><input type='text' name='name' class='required'/></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3" align="left"><label>Your email address:</label></div>
        <div class="grid9" align="right"><input type='text' name='email' class="required email"/></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3" align="left"><label>Enter your desired password which will be required to login later:</label></div>
        <div class="grid9" align="right"><input type='password' name='password' id='password' class='required'/></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3" align="left"><label>The name of the boat to be sold:</label></div>
        <div class="grid9" align="right"><input type='text' name='boat_name'  class='required' /></div>
        <div class="clear"></div>
    </div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Register</button>
		</div>
		<div class="clear"></div>
	</div>
</div>
</form>
