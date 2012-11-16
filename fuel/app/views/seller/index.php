<div class="widget fluid" style="width: 500px;">

    <div class="whead">
		<div>
			<h6>Your Submitted Yachtshares</h6>
		</div>
		<div style='text-align: right'>
			<a href="<?= Uri::create('seller/search'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;"><span class="icon-add"></span><span>New Yacht Share</span></button></a>
		</div>
		<div class="clear"></div>
	</div>

    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="resize2">
<?php if ($yachtshares): ?>
        <thead>
            <tr>
                <td class="sortCol"><div>Name<span></span></div></td>
                <td class="sortCol"><div>Location<span></span></div></td>
                <td class="sortCol" width="70px"><div>Actions<span></span></div></td>
            </tr>
        </thead>
        <tbody>
	<?php foreach ($yachtshares as $yachtshare): ?>
	        <tr class="boat">
	            <td class="boatname"><a href="<?= Uri::create('yachtshare/view/'.$yachtshare->id); ?>"><?= $yachtshare->name; ?></a></td>
	            <td><?= $yachtshare->location_specific; ?></td>
	            <td align="center"><a href="<?=Uri::create('file/yachtshare/'.$yachtshare->id);?>" class="tablectrl_small bBlue tipS" original-title="Upload Files for this yacht share"><span class="iconb" data-icon=""></span></a></td>
	        </tr>
	<?php endforeach; ?>
<?php else: ?>
			<tr>
				<td>You have not yet created any yacht shares, click the upper right-hand button to do so.</td>
			</tr>
        </tbody>
<?php endif; ?>
    </table>
</div>

<div class="widget fluid" style="width: 500px;">

    <div class="whead">
		<div>
			<h6>Yachtshares that you have saved to be submitted later</h6>
		</div>
		<div class="clear"></div>
	</div>

<?php if ($yachtshares_saved_for_later): ?>
    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault" id="resize2">
        <thead>
            <tr>
                <td class="sortCol"><div>Name<span></span></div></td>
                <td class="sortCol"><div>Location<span></span></div></td>
                <td class="sortCol" width="90px"><div>Actions<span></span></div></td>
            </tr>
        </thead>
        <tbody>
	<?php foreach ($yachtshares_saved_for_later as $yachtshare): ?>
	<script type="text/javascript">
	$(function(){
		var $dialog = $('<div></div>')
			.html('Are you sure you want to delete this saved yachtshare form?')
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

		$('#delete_<?=$yachtshare->id;?>').click(function() {
			$dialog.dialog('open');
			// prevent the default action, e.g., following a link
			return false;
		});
	});
	</script>
	        <tr class="boat">
	            <td class="boatname"><?= $yachtshare->name; ?></td>
	            <td><?= $yachtshare->location_specific; ?></td>
	            <td align="center">
					<a href="<?=Uri::create('yachtshare/update'.$yachtshare->id);?>" class="tablectrl_small bGreen tipS" original-title="Continue editing this form"><span class="iconb" data-icon=""></span></a>
					<a href="<?=Uri::create('file/yachtshare/'.$yachtshare->id);?>" class="tablectrl_small bBlue tipS" original-title="Upload Files for this yacht share"><span class="iconb" data-icon=""></span></a>
					<a href="#" id="delete_<?=$yachtshare->id;?>" class="tablectrl_small bRed tipS" original-title="Delete"><span class="iconb" data-icon=""></span></a> 
				</td>
	        </tr>
	<?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
	<div class="formRow">
			You currently have no yachtshares saved for later.
		<div class="clear"></div>
	</div>
<?php endif; ?>
</div>
