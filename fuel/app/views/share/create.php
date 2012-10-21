<form action="<?= Uri::create('share/create'); ?>" method="POST" accept-charset="utf-8">
<div class="widget fluid">

    <div class="whead">
		<h6>New Yacht Share</h6>
		<div style='text-align: right;'>
		<a href="<?= Uri::create('share'); ?>"><button class="buttonS bRed" style="margin: 6px 6px;" type="button"><span class="icon-list-2"></span><span>All Shares</span></button></a>
		</div>
		<div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>Yacht:</label></div>
        <div class="grid9 searchDrop">
	
			<select name="boat_id" class="select">
				<? foreach($boats as $boat): ?>
				<option value="<?= $boat->id; ?>"><?= $boat->name; ?></option>
				<? endforeach; ?>
			</select>
			
		</div>

        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Fraction (in decimal form, i.e. "0.5"):</label></div>
        <div class="grid9"><input type='text' name='fraction' /></div>
        <div class="clear"></div>
    </div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Save</button>
		</div>
		<div class="clear"></div>
	</div>

</div>
</form>
