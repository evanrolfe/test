<?= render('boat/_nav', array('boat' => $boat)); ?>
</div>

<form action="<?= Uri::create('boat/edit/'.$boat->id); ?>" method="POST" accept-charset="utf-8">
<div class="widget fluid">

    <div class="whead"><h6>Edit Boat</h6><div class="clear"></div></div>

    <div class="formRow">
        <div class="grid3"><label>Name:</label></div>
        <div class="grid9"><input type='text' name='name' value="<?= $boat->name; ?>" /></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Location:</label></div>
        <div class="grid9"><input type='text' name='location' value="<?= $boat->location; ?>" /></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Length:</label></div>
        <div class="grid9"><input type='text' name='length' size="4" value="<?= $boat->length; ?>" /></div>
        <div class="clear"></div>
    </div>
	<? foreach($formfields as $formfield): ?>

    <div class="formRow">
        <div class="grid3"><label><?= $formfield->key; ?>:</label></div>
        <div class="grid9">
			<? if($formfield->type == "varchar"): ?>

				<input type='text' name="field_<?= $formfield->id; ?>" size="3" value="<?= $fields[$formfield->key]; ?>">

			<? elseif($formfield->type == "text"): ?>

				<textarea rows="6" cols="" name="field_<?= $formfield->id; ?>"><?= $fields[$formfield->key]; ?></textarea>

			<? endif; ?>
		</div>
        <div class="clear"></div>
    </div>

	<? endforeach; ?>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Save</button>
		</div>
		<div class="clear"></div>
	</div>
</div>
</form>
