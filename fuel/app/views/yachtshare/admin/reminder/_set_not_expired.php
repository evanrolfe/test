<div class="widget fluid">
    <div class="whead">
		<div>
			<h6>Reminder Status:</h6> <span style="display: inline-block; margin-top: 8px;" class="">SET TO REMIND ON <?=Date::forge($yachtshare->reminder_expires_at)->format('%d/%m/%Y');?></span>
		</div>
		<div class="clear"></div>
	</div>

	<div class="formRow" id="reminder_form">
        <div class="grid3">Message:</div>
        <div class="grid9">
			<input type="text" name="reminder" id="reminder" value="<?=$yachtshare->reminder;?>">
		</div>
   		<div class="clear"></div>
	</div>

	<div class="formRow" id="reminder_form2">
        <div class="grid3">Remind me on:</div>
        <div class="grid9">
			<input type="text" class="maskDate" id="maskDate" name="expires_at" style="width: 100px;" value="<? if($yachtshare->reminder_expires_at > 0){ echo Date::forge($yachtshare->reminder_expires_at)->format('%d/%m/%Y'); }?>">
			<span class="note">Example: 31/12/2012.</span>			
		</div>
   		<div class="clear"></div>
	</div>

    <div class="whead" id="reminder_form3">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right'>
			<button class="buttonS bBlue" style="margin: 6px 6px;" type="submit" name="delete">Delete Reminder</button>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit" name="update">Update Reminder</button>
		</div>
		<div class="clear"></div>
    </div>
</div>
