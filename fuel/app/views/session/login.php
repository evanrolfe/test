<ul class="middleNavA">
            <li><a href="<?=Uri::create('yachtshare/create');?>" title="Upload files"><img src="<?= Uri::create('public/assets/images/icons/color/suppliers.png');?>"><span>Seller Form</span></a></li>    
            <li><a href="<?=Uri::create('buyer/create');?>" title="Add an article"><img src="<?= Uri::create('public/assets/images/icons/color/donate.png');?>"><span>Buyer Enquiry</span></a></li>
            <li><a href="<?=Uri::create('front');?>" title="Upload files"><img src="<?= Uri::create('public/assets/images/icons/color/world.png');?>"><span>Front End Site</span></a></li>            
        </ul>

<form action="<?= Uri::create('session/create'); ?>" method="POST" accept-charset="utf-8">
<div class="widget fluid" style="width: 450px;">

    <div class="whead">
		<h6>Administrator Login</h6>

		<div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>Username:</label></div>
        <div class="grid9"><input type='text' name='email' /></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Password:</label></div>
        <div class="grid9"><input type='password' name='password' /></div>
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
