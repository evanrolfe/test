<?= render('yachtshare/admin/_nav',array('yachtshare' => $yachtshare)); ?>

<? if(sizeof($yachtshare->active_actionsteps()) > 0): ?>
<div class="widget fluid">

    <div class="whead">
		<h6>Sale Progress with Buyer: <a href="<?= Uri::create('buyer/view/'.$yachtshare->active_buyer()->id); ?>"><?= $yachtshare->active_buyer()->name; ?></a></h6>
		<div class="clear"></div>
	</div>

	<? foreach($yachtshare->active_actionsteps() as $actionstep): ?>
    <div class="formRow">
        <div class="grid3"><label><?= $actionstep->set->title; ?></label></div>
        <div class="grid9"><?= $actionstep->note; ?>  (<?= Date::forge($actionstep->date)->format("%d/%m/%Y"); ?>)</div>
        <div class="clear"></div>
    </div>
	<? endforeach; ?>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<a href="<?= Uri::create('actionstep/create/'.$yachtshare->id.'/'.$yachtshare->active_buyer()->id); ?>" class="buttonS bGreen" style="margin: 6px 6px; color:white;">Add Action Step</a>
		</div>
		<div class="clear"></div>
	</div>
</div>
<? else: ?>
<div class="widget fluid">

    <div class="whead">
		<h6>Sale Progress</h6>
		<div class="clear"></div>
	</div>

    <div class="formRow">
		No sale activity so far.
        <div class="clear"></div>
    </div>
<? endif; ?>
