<? if($yachtshare->temp): ?>
	<script type="text/javascript">
	$(function(){
		var $dialog = $('<div></div>')
			.html('Are you sure you want to delete this temporarily saved yachtshare form?<br>Keep in mind the user may still want to complete this form.')
			.dialog({
				autoOpen: false,
				title: "Deleting Saved Yachtshare Form",
				modal: true,
				buttons: {
				    "Yes": function () {
						location.href="<?= Uri::create('yachtshare/delete/'.$yachtshare->id); ?>";
				    },
				    "No": function () {
				        $(this).dialog("close");
				    }
				}
			});

		$('#delete').click(function() {
			$dialog.dialog('open');
			// prevent the default action, e.g., following a link
			return false;
		});
	});
	</script>
	<br>
	<h3>The seller: <?=$yachtshare->seller->name; ?>, has temporarily saved this form:</h3>
<? else: ?>
	<?= render('yachtshare/admin/_nav',array('yachtshare' => $yachtshare)); ?>

	<?if($yachtshare->status() == 'Sold'):?><?=render('actionstep/_sale_complete',array('yachtshare' => $yachtshare));?><?endif;?>

	<div class="widget fluid">
		<div class="whead">
			<div>
				<h6>Active Sales</h6>
			</div>
			<div class="clear"></div>
		</div>

		<? if(sizeof($yachtshare->buyers()) > 0): ?>
			<? foreach($yachtshare->buyers() as $buyer): ?>
		<div class="formRow">
			<div class="grid3"><label><a href="<?= Uri::create('buyer/view/'.$buyer->id);?>"><?= $buyer->name; ?></a></label></div>
			<div class="grid9">

				<? foreach($buyer->actionsteps as $actionstep): ?>
					<?= render('actionstep/_row', array('actionstep' => $actionstep,'from_page' => 'yachtshare')); ?>
				<? endforeach; ?>

				<div text-align="right">
					<? if($yachtshare->is_onhold() || in_array($buyer->actionsteps[0]->type, array('cancel','complete',))): ?>
						<s>Add Action Step</s>
					<? else: ?>
						<a href="<?= Uri::create('actionstep/create/'.$yachtshare->id.'/'.$buyer->id.'/action/yachtshare'); ?>">Add Action Step</a>
					<? endif; ?>
				</div>
			</div>
	   		<div class="clear"></div>
		</div>	
			<? endforeach; ?>
		<? else: ?>
		<div class="formRow">
			This yacht share has not been introduced to any buyers yet.
	   		<div class="clear"></div>
		</div>
		<? endif; ?>

	</div>

	<? if(count($similar) > 0): ?>
	<div class="widget fluid">
		<div class="whead">
			<div>
				<h6>Other yacht shares found for (possibly) the same yacht</h6>
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<? foreach($similar as $y): ?>
				<a href="<?= Uri::create('yachtshare/view/'.$y->id);?>"><?= $y->name; ?> - <?= $y->location_specific; ?> - <?= Date::forge($y->created_at)->format("%b %Y"); ?></a><br>
			<? endforeach; ?>
	   		<div class="clear"></div>
		</div>


	</div>
	<? endif; ?>

<? endif; ?>

<div class="widget fluid">

    <div class="whead">
		<h6>Details</h6>
		<? if($yachtshare->temp): ?>
			<div style='text-align: right'>
				<a href="#" id="delete"><button class="buttonS bRed tipS" style="margin: 6px 6px;" type="button" original-title="Be careful deleting these, the seller may still want to submit this yachtshare.">Delete</button></a>
			</div>
		<? endif; ?>
		<div class="clear"></div>
	</div>

	<? foreach($formfields as $field): ?>
		<? if($field->type == 'terms_and_conditions'){ continue; } ?>
    <div class="formRow">
        <div class="grid3"><label><?= $field->label; ?>:</label></div>
        <div class="grid9">
			<? if($field->search_field): ?>
				<? $tag = $field->tag; ?>

				<? if($field->tag == 'share_size'): ?>
					<?= $yachtshare->boat_details['share_size_fraction']; ?>
				<? else: ?>
					<?= $yachtshare->$tag;?>
				<? endif; ?>

			<? else: ?>

					<?= str_replace("\n", "<br>", $yachtshare->boat_details[$field->tag]); ?>

			<? endif; ?>
		</div>
        <div class="clear"></div>
    </div>
	<? endforeach; ?>

</div>

<? if($yachtshare->reminder_expires_at > time() && $yachtshare->reminder_expires_at > 0): ?>
	<?= render('yachtshare/admin/_reminder',array('yachtshare' => $yachtshare)); ?>
<? endif; ?>
