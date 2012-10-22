<form action="<?= Uri::create('session/create'); ?>" method="POST" accept-charset="utf-8">
<div class="widget fluid" style="width: 450px;">

    <div class="whead">
		<h6>Login</h6>

		<div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>Email:</label></div>
        <div class="grid9"><input type='text' name='email' /></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Password:</label></div>
        <div class="grid9"><input type='password' name='password' /></div>
        <div class="clear"></div>
    </div>

    <div class="formRow" align="left">
<a href="<?= Uri::create('session/forgot');?>">Forgot Password?</a>
        <div class="clear"></div>
    </div>
	<div class="whead">
        <div class="grid6" align="left"></div>
		
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Login</button>
		</div>
		<div class="clear"></div>
	</div>

</div>
</form>
