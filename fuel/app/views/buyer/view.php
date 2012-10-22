<?= render('buyer/_nav', array('buyer' => $buyer)); ?>

<div class="widget fluid">
    <div class="whead">
		<div>
			<h6>Active Sales</h6>
		</div>
		<div class="clear"></div>
	</div>

	<? if(sizeof($buyer->yachtshares()) > 0): ?>
		<? foreach($buyer->yachtshares() as $yachtshare): ?>
	<div class="formRow">
		<div class="grid3"><label><a href="<?= Uri::create('yachtshare/view/'.$yachtshare->id);?>"><?= $yachtshare->name; ?></a></label></div>
		<div class="grid9">
			<? if($yachtshare->actionsteps[0]->type == 'cancel'): ?>

				<a onclick="$('#actionsteps').toggle();">View Actionsteps</a>

				<div id="actionsteps" style="display: none; ">
					<? foreach($yachtshare->actionsteps as $actionstep): ?>
							<?= render('actionstep/_row', array('actionstep' => $actionstep,'from_page' => 'buyer')); ?>
					<? endforeach; ?>
				</div>

			<? else: ?>

				<? foreach($yachtshare->actionsteps as $actionstep): ?>
					<?= render('actionstep/_row', array('actionstep' => $actionstep, 'from_page' => 'buyer')); ?>
				<? endforeach; ?>

			<? endif; ?>

			<div text-align="right">
				<? if($yachtshare->onhold || in_array($yachtshare->actionsteps[0]->type, array('complete','cancel'))): ?>
					<s>Add Action Step</s>
				<? else: ?>
					<a href="<?= Uri::create('actionstep/create/'.$yachtshare->id.'/'.$buyer->id.'/action/buyer'); ?>">Add Action Step</a>
				<? endif; ?>
			</div>
		</div>
   		<div class="clear"></div>
	</div>	
		<? endforeach; ?>
	<? else: ?>
	<div class="formRow">
		The buyer has not been introduced to any yachtshares yet.
   		<div class="clear"></div>
	</div>
	<? endif; ?>

</div>

<div class="widget fluid">

    <div class="whead">
		<h6>Boat Specification Required:</h6>
		<div class="clear"></div>
	</div>

	<? foreach($boat_specifications as $label => $value): ?>
		<div class="formRow">
			<div class="grid3"><label><?= $label; ?></label></div>
			<div class="grid9"><?= $value; ?></div>
			<div class="clear"></div>
		</div>
	<? endforeach; ?>
</div>

<div class="widget fluid">

    <div class="whead">
		<h6>Details of Buyer</h6>
		<div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>Name:</label></div>
        <div class="grid9"><?= $buyer->name; ?></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Email:</label></div>
        <div class="grid9"><?= $buyer->email; ?></div>
        <div class="clear"></div>
    </div>

	<? foreach($buyer_info as $key => $value): ?>
    <div class="formRow">
        <div class="grid3"><label><?= $key; ?></label></div>
        <div class="grid9"><?= $value; ?></div>
        <div class="clear"></div>
    </div>
	<? endforeach; ?>

</div>
