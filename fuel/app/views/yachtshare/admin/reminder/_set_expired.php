<div class="widget fluid">
    <div class="whead">
		<div>
			<h6>Reminder:</h6> <span style="display: inline-block; margin-top: 3px;" class="redBack">ACTIVE SINCE <?=Date::forge($yachtshare->reminder_expires_at)->format('%d/%m/%Y');?></span>
		</div>
		<div class="clear"></div>
	</div>

	<div class="formRow" id="reminder_form">
        Your message: <h3><?=$yachtshare->reminder;?></h3>
   		<div class="clear"></div>
	</div>

    <div class="whead" id="reminder_form3">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right'>
			<button class="buttonS bBlue" style="margin: 6px 6px;" type="submit" name="delete">Okay, clear this reminder</button>
		</div>
		<div class="clear"></div>
    </div>
</div>
