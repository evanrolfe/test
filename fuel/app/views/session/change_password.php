<form action="<?= Uri::create('session/change_password/'.$params); ?>" method="POST" accept-charset="utf-8">
<div class="widget fluid" style="width: 450px;">

    <div class="whead">
    	<h6>Hello, <?= $user->name; ?>, to change your password, please enter your desired password in the box below and click "Change Password".
    	</h6>
		<div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>New Password:</label></div>
        <div class="grid9"><input type='password' name='new_password' /></div>
        <div class="clear"></div>
    </div>
	<div class="whead">
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Change Password</button>
		</div>
		<div class="clear"></div>
	</div>

</div>
</form>