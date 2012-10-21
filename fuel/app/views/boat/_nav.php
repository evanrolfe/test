<script type="text/javascript">
$(function(){
	var $dialog = $('<div></div>')
		.html('Are you sure you want to delete this boat?')
		.dialog({
			autoOpen: false,
			title: "Deleting Boat: <?=$boat->name;?>",
			modal: true,
		    buttons: {
		        "Yes": function () {
					location.href="<?= Uri::create('boat/delete/'.$boat->id); ?>";
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
		<h6>Viewing Boat</h6>
		<div style='text-align: right;'>
		<a href="<?= Uri::create('boat'); ?>"><button class="buttonS bRed" style="margin: 6px 6px;"><span class="icon-list-2"></span><span>All Boats</span></button></a>
		</div>
		<div class="clear"></div>
	</div>
    <div class="formRow">
		<ul class="middleFree" style="margin-top: 0px;">
            <li><a href="<?= Uri::create('boat/view/'.$boat->id); ?>" class="bBlue"><span class="iconb" data-icon=""></span><span>Details</span></a></li>
            <li><a href="<?= Uri::create('boat/edit/'.$boat->id); ?>" class="bGreen"><span class="iconb" data-icon=""></span><span>Edit</span></a></li>
            <li><a href="<?= Uri::create('boat/images/'.$boat->id); ?>" class="bGold"><span class="iconb" data-icon=""></span><span>Images</span></a><strong><?= sizeof($boat->images); ?></strong></li>
            <li><a href="<?= Uri::create('boat/shares/'.$boat->id); ?>" class="bLightBlue"><span class="iconb" data-icon=""></span><span>Shares</span></a><strong><?= sizeof($boat->shares); ?></strong></li>
            <li><a href="#" class="bRed" id="opener"><span class="iconb" data-icon=""></span><span>Delete</span></a></li>
        </ul>
    </div>

    <div class="formRow">
        <div class="grid3"><label><b>Name:</b></label></div>
        <div class="grid9"><?= $boat->name; ?></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label><b>Location:</b></label></div>
        <div class="grid9"><?= $boat->location; ?></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label><b>Length:</b></label></div>
        <div class="grid9"><?= $boat->length; ?></div>
        <div class="clear"></div>
    </div>
