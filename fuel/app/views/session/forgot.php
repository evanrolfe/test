
<form action="<?= Uri::create('session/forgot'); ?>" method="POST" accept-charset="utf-8">
<div class="widget fluid" style="width: 450px;">

    <div class="whead">
		<h6>Password Recovery</h6>
		<div class="clear"></div>
	</div>

    <div class="formRow">
Please enter your email and a new password will be sent to you.
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Email:</label></div>
        <div class="grid9"><input type='text' name='email' /></div>
        <div class="clear"></div>
    </div>
	<div class="whead">
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Reset Password</button>
		</div>
		<div class="clear"></div>
	</div>

</div>
</form>
<br>
