<script type="text/javascript">
function select_type(type)
{
	switch(type)
	{
		case "introduction":
			$("input[name=note_only]").val("");
			$("#actionstep").hide();
			$("input[name=introduction]").val("1");
			$("#date").show();
			$("#hold_period").show();
			$("#note").show();
		break;

		case "action":
			$("#actionstep").show();
			$("#date").show();
			$("#hold_period").hide();
			$("#note").show();
		break;

		case "hold":
			$("#actionstep").hide();
			$("#date").hide();
			$("#hold_period").show();
			$("#note").show();
		break;

		case "note":
			$("input[name=note_only]").val("1");
			$("#actionstep").hide();
			$("#date").show();
			$("#hold_period").hide();
			$("#note").show();
		break;

		case "cancel":
			$("input[name=cancel]").val("1");
			$("#actionstep").hide();
			$("#date").show();
			$("#hold_period").hide();
			$("#note").show();
		break;

		case "complete":
			$("input[name=complete]").val("1");
			$("#actionstep").hide();
			$("#date").show();
			$("#hold_period").hide();
			$("#note").show();
		break;
	}

  //Submit button row
  if(type == 'introduction')
  {
    $("#introduce_submit").show();
	  $("#save_row").hide();
  }else{
    $("#introduce_submit").hide();
	  $("#save_row").show();
  }
}

$(function (){
	if("<?= $selected_actionstep; ?>" != 'none')
	{
		select_type("<?= $selected_actionstep; ?>");
	}

	$("#create_form").validate();
});
</script>

<form action="<?= Uri::create('actionstep/create'); ?>" method="POST" accept-charset="utf-8" id="create_form">
<input type="hidden" name="note_only">
<input type="hidden" name="introduction">
<input type="hidden" name="cancel">
<input type="hidden" name="complete">
<input type="hidden" name="from_page" value="<?=$from_page;?>">
<div class="widget fluid">

    <div class="whead"><h6>Add Action Step</h6><div class="clear"></div></div>

    <div class="formRow">
        <div class="grid3"><label>Buyer:</label></div>
        <div class="grid9">
			<? if($buyer): ?>
				<?= $buyer->name; ?><br>
				<?= $buyer->email; ?>
				<input type="hidden" name="buyer_id" value="<?= $buyer->id; ?>">
			<? else: ?>
				<div class="">
					<select name="buyer_id" class="" onchange="$('#buyer_info').show()">
						<option value="">Select buyer</option>
						<? foreach($buyers as $buyer): ?>
						<option value="<?= $buyer->id; ?>"><?= $buyer->name; ?></option>
						<? endforeach; ?>
					</select>
				</div>

           <ul class="messagesOne" style='display: none' id="buyer_info">           
                <li class="by_user">
                    <div class="messageArea">
                        <div class="infoRow">
                            <span class="name"><strong>Evan</strong></span>
                            <div class="clear"></div>
                        </div>
                        Buyer info goes here. Buyer info goes here. Buyer info goes here. Buyer info goes here. Buyer info goes here. 
                    </div>
                    <div class="clear"></div>
                </li>              
            </ul>
			<? endif; ?>
		</div>
        <div class="clear"></div>
 
    </div>

    <div class="formRow">
        <div class="grid3"><label>Boat:</label><input type="hidden" name="boat_share_id" value="<?= $yachtshare->id; ?>"></div>
        <div class="grid9">
			<div class="grid2"><b>Name:</b></div>
			<div class="grid2"><?= $yachtshare->name; ?></div>
			<div class="grid2"><b>Location:</b></div>
			<div class="grid2"><?= $yachtshare->location_specific; ?></div>
			
			<div class="grid2"><b>Share size:</b></div>
			<div class="grid2"><?= $yachtshare->share_size; ?></div>
		</div>
        <div class="clear"></div>
    </div>

  <div class="formRow">
        <div class="grid3"><label>Select Type:</label></div>
        <div class="grid9">
	<? $types = array('introduction' => 'Introduction', 'action' => 'Action Step', 'note' => 'Note', 'hold' => 'Put yachtshare on hold', 'complete' => 'Sale Complete', 'cancel' => 'Cancel Sale'); ?>
				<select id="type" class="required" onchange="select_type(this.value)">
					<option value="">Select</option>
					<? foreach($types as $key => $value): ?>
						<option value="<?=$key;?>" <? if($selected_actionstep == $key): ?>selected="yes"<? endif; ?>><?=$value;?></option>
					<? endforeach; ?>
				</select>
		</div>
        <div class="clear"></div>
    </div>

   <div class="formRow" id="date" style="display:none;">
        <div class="grid3"><label>Date:</label></div>
        <div class="grid9">
			<input type="text" class="maskDate" id="maskDate" name="date" style="width: 100px;">
			<span class="note">Example: 31/12/2012. Leave blank for today's date.</span>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="actionstep" style="display:none;">
        <div class="grid3"><label>Action step:</label></div>
        <div class="grid9">
			<div class="noSearch">
				<select name="actionstep_set_id" class="" style="width: 250px;">
					<option value="">Select Action Step</option>
					<? foreach($actionsteps as $step): ?>
					<option value="<?= $step->id; ?>"><?= $step->order; ?>.  <?= $step->title; ?></option>
					<? endforeach; ?>
				</select>
			</div>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="hold_period" style="display:none;">
        <div class="grid3"><label>Mark as on hold:</label></div>
        <div class="grid9">

			<div class="">
				<select name="hold_days" class=""  style="width: 70px;">
					<option value="">Days</option>

					<? for($i=1; $i<=100; $i++): ?>
					<option value="<?= $i; ?>"><?= $i; ?></option>
					<? endfor; ?>
				</select>

			 Days / 

				<select name="hold_hours" class=""  style="width: 70px;">
					<option value="">Hours</option>

					<? for($i=1; $i<=24; $i++): ?>
					<option value="<?= $i; ?>"><?= $i; ?></option>
					<? endfor; ?>
				</select>
			 Hours
			<span class="note">You may leave these two fields blank if you do not wish a hold to be placed on the yachtshare.</span>
			</div>


		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="note" style="display:none;">
        <div class="grid3"><label>Note:</label></div>
        <div class="grid9"><textarea rows="6" cols="" name="note"></textarea></div>
        <div class="clear"></div>
    </div>

    <div class="whead" id="introduce_submit" style="display:none;">
		  <h6 style="opacity: 0.0;">-</h6>
		  <div style='text-align: right;'>
			  <button class="buttonS bBlue" style="margin: 6px 6px;" type="submit" name="email">Introduce with Email</button>
			  <button class="buttonS bGreen" style="margin: 6px 6px;" type="submit" name="submit">Only Introduce</button>
      </div>
        <div class="clear"></div>
    </div>

	<div class="whead" style="display:none;" id="save_row">
		  <h6 style="opacity: 0.0;">-</h6>
		  <div style='text-align: right;'>
			  <button class="buttonS bGreen" style="margin: 6px 6px;">Save</button>
		  </div>
		  <div class="clear"></div>
	</div>

</div>
</form>
