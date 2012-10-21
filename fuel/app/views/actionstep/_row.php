<script type="text/javascript">
$(function(){
	var $dialog = $('<div></div>')
		.html('Are you sure you want to delete this actionstep?')
		.dialog({
			autoOpen: false,
			title: "Deleting actionstep",
			modal: true,
		    buttons: {
		        "Yes": function () {
					location.href="<?= Uri::create('actionstep/delete/'.$actionstep->id.'/'.$from_page); ?>";
		        },
		        "No": function () {
		            $(this).dialog("close");
		        }
		    }
		});

	$('#actionstep_<?=$actionstep->id;?>').click(function() {
		$dialog.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
});
</script>



<? if($actionstep->type == 'action' || $actionstep->type == 'introduction'): ?>
	<a id="actionstep_<?=$actionstep->id;?>" href="<?=Uri::create('actionstep/delete/'.$actionstep->id.'/'.$from_page);?>">[X] </a>
	<b><?= $actionstep->title; ?></b> - <?= $actionstep->note; ?> (<?= Date::forge($actionstep->occurred_at)->format("%d/%m/%Y"); ?>)<br>

<? elseif($actionstep->type == 'hold' && $actionstep->expires_at > time()): ?>
	<a id="actionstep_<?=$actionstep->id;?>" href="<?=Uri::create('actionstep/delete/'.$actionstep->id.'/'.$from_page);?>">[X] </a>
	<b><span class="redBack"><?= $actionstep->title; ?></span> </b> - <?= $actionstep->note; ?> (<?= Date::forge($actionstep->occurred_at)->format("%d/%m/%Y"); ?>)<br>

<? elseif($actionstep->type == 'note'): ?>
	<a id="actionstep_<?=$actionstep->id;?>" href="<?=Uri::create('actionstep/delete/'.$actionstep->id.'/'.$from_page);?>">[X] </a>
	<b><?= $actionstep->title; ?></b> - <?= $actionstep->note; ?> (<?= Date::forge($actionstep->occurred_at)->format("%d/%m/%Y"); ?>)<br>

<? elseif($actionstep->type == 'cancel'): ?>

	<div <? if($actionstep->title != 'Cancelled'): ?>style="opacity: 0.4;"<? endif; ?>><b><?= $actionstep->title; ?></b> - <?= $actionstep->note; ?> (<?= Date::forge($actionstep->occurred_at)->format("%d/%m/%Y"); ?>)</div>

<? elseif($actionstep->type == 'complete'): ?>

	<div <? if($actionstep->title != 'Sale Completed'): ?>style="opacity: 0.4;"<? endif; ?>><b><?= $actionstep->title; ?></b> - <?= $actionstep->note; ?> (<?= Date::forge($actionstep->occurred_at)->format("%d/%m/%Y"); ?>)</div>

<? endif; ?>
