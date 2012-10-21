<form action="<?= Uri::create('actionstep/create'); ?>" method="POST" accept-charset="utf-8">
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
				<div class="noSearch">
					<select name="buyer_id" class="select" onchange="$('#buyer_info').show()">
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
        <div class="grid3"><label>Sale progress:</label></div>
        <div class="grid9">
			Last Action step: 
		</div>
        <div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>Boat:</label><input type="hidden" name="yachtshare_id" value="<?= $yachtshare->id; ?>"></div>
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
        <div class="grid3"><label>Date:</label></div>
        <div class="grid9">
			<input type="text" class="maskDate" id="maskDate" name="occured_at" style="width: 75px;">
			<span class="note">Example: 31/12/2012. Leave blank for today's date.</span>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Action step:</label></div>
        <div class="grid9">
			<div class="noSearch">
				<select name="title" class="select">
					<option value="">Select Action Step</option>
					<option value="Introduction">Introduction</option>
					<option value="Agreement to Purchase">Agreement to Purchase</option>
					<option value="Inspection Arranged">Inspection Arranged</option>
					<option value="Offer Received">Offer Received</option>
				</select>
			</div>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Mark as on hold:</label></div>
        <div class="grid9">

			<div class="noSearch">
				<select name="hold_days" class="select" width='200px'>
					<option value="">Days</option>

					<? for($i=1; $i<=100; $i++): ?>
					<option value="<?= $i; ?>"><?= $i; ?></option>
					<? endfor; ?>
				</select>

			 Days / 

				<select name="hold_hours" class="select" width='200px'>
					<option value="">Hours</option>

					<? for($i=1; $i<=24; $i++): ?>
					<option value="<?= $i; ?>"><?= $i; ?></option>
					<? endfor; ?>
				</select>
			 Hours
			</div>


		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Note:</label></div>
        <div class="grid9"><textarea rows="6" cols="" name="note"></textarea></div>
        <div class="clear"></div>
    </div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Save</button>
		</div>
		<div class="clear"></div>
	</div>

</div>
</form>
