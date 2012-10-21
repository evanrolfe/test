<script type="text/javascript">
$(function(){
	var $dialog = $('<div></div>')
		.html('Are you sure you want to delete the yacht share: <?=$yachtshare->name;?>?')
		.dialog({
			autoOpen: false,
			title: "Deleting yacht share:",
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

	$('#opener').click(function() {
		$dialog.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
});
</script>

<div class="widget fluid">

    <div class="whead">
		<h6>Yacht Share: <?= $yachtshare->name; ?></h6>
		<div class="clear"></div>
	</div>
    <div class="formRow">
		<ul class="middleFree" style="margin-top: 0px;">
            <li><a href="<?= Uri::create('yachtshare/view/'.$yachtshare->id); ?>" class="bBlue"><span class="iconb" data-icon=""></span><span>Details</span></a></li>
            <li><a href="<?= Uri::create('yachtshare/edit/'.$yachtshare->id); ?>" class="bGreen"><span class="iconb" data-icon=""></span><span>Edit</span></a></li>
            <li><a href="<?= Uri::create('file/yachtshare/'.$yachtshare->id); ?>" class="bGold"><span class="iconb" data-icon=""></span><span>Files</span></a></li>
            <li style="width: 100px;"><a href="<?= Uri::create('yachtshare/find_buyers/'.$yachtshare->id); ?>" class="bLightBlue"><span class="iconb" data-icon=""></span><span>Find Buyers</span></a></li>
			<? if($yachtshare->status() == 'Deactivated'): ?>
            	<li style="width: 90px;"><a href="<?=Uri::create('yachtshare/deactivate/'.$yachtshare->id);?>" class="bGreen"><span class="iconb" data-icon=""></span><span>Activate</span></a></li>
			<? else: ?>
            	<li style="width: 90px;"><a href="<?=Uri::create('yachtshare/deactivate/'.$yachtshare->id);?>" class="bRed"><span class="iconb" data-icon=""></span><span>Deactivate</span></a></li>
			<? endif; ?>
        </ul>
    </div>

	<? if($yachtshare->status() == 'Deactivated'): ?>
    <div class="formRow" align="right">
		<a href="#" id="opener">Delete Permanently</a>
    </div>
	<? endif; ?>
</div>
