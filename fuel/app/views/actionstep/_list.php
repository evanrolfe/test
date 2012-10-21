<div class="widget fluid">
    <div class="whead">
		<div>
			<h6><?= $heading; ?></h6>
		</div>
		<div class="clear"></div>
	</div>

	<? if(sizeof($potentials) > 0): ?>
		<? foreach($potentials as $buyer): ?>
	<div class="formRow">
		<div class="grid3"><label><a href="<?= Uri::create('buyer/view/'.$buyer->id);?>"><?= $buyer->name; ?></a></label></div>
		<div class="grid9">

			<? foreach($buyer->actionsteps as $actionstep): ?>
				<b><?= $actionstep->title; ?></b> - <?= $actionstep->note; ?> (<?= Date::forge($actionstep->occurred_at)->format("%d/%m/%Y"); ?>)<br>
			<? endforeach; ?>

			<div text-align="right">
			<? if($from = 'yachtshare'): ?>

				<a href="<?= Uri::create('actionstep/create/'.$buyer->id.'/'.$yachtshare->id); ?>">Add Action Step</a>
			<? else: ?>
				<a href="<?= Uri::create('actionstep/create/'.$yachtshare->id.'/'.$buyer->id); ?>">Add Action Step</a>
			<? endif; ?>
			</div>
		</div>
   		<div class="clear"></div>
	</div>	
		<? endforeach; ?>
	<? else: ?>
	<div class="formRow">
		The buyer has not been introduced to any yachts yet.
   		<div class="clear"></div>
	</div>
	<? endif; ?>

</div>
