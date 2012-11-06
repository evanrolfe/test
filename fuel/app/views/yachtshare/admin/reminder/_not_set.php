<script type="text/javascript">
function toggle_reminder(from_href_link)
{
	$("#reminder_form").toggle();
	$("#reminder_form2").toggle();
	$("#reminder_form3").toggle();

	if(from_href_link)
	{
		if($("#reminder_active").prop('checked'))
		{
			$("#reminder_active").prop('checked', false);	
		}else{
			$("#reminder_active").prop('checked', true);
		}
	}
}
</script>

<div class="widget fluid">
    <div class="whead">
		<div>
			<h6>Reminder Status:</h6> <span style="display: inline-block; margin-top: 3px;" class="greenBack">NOT SET</span>
		</div>
		<div class="clear"></div>
	</div>

	<div class="formRow">
        <input type="checkbox" id="reminder_active" onclick="toggle_reminder()" <? if($yachtshare->reminder_expires_at > time()): ?>checked="yes"<? endif; ?>> <a href="#" onclick="toggle_reminder(true)">Set Reminder?</a>
   		<div class="clear"></div>
	</div>

	<div class="formRow" id="reminder_form" style="display:none;">
        <div class="grid3">Reminder:</div>
        <div class="grid9">
			<input type="text" name="reminder" id="reminder" value="<?=$yachtshare->reminder;?>">
		</div>
   		<div class="clear"></div>
	</div>

	<div class="formRow" id="reminder_form2" style="display:none;">
        <div class="grid3">Remind me on:</div>
        <div class="grid9">
			<input type="text" class="maskDate" id="maskDate" name="expires_at" style="width: 100px;" value="<? if($yachtshare->reminder_expires_at > 0){ echo Date::forge($yachtshare->reminder_expires_at)->format('%d/%m/%Y'); }?>">
			<span class="note">Example: 31/12/2012.</span>			
		</div>
   		<div class="clear"></div>
	</div>

    <div class="whead" id="reminder_form3" style="display:none;">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right'>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit" name="update">Save Reminder</button>
		</div>
		<div class="clear"></div>
    </div>
</div>
