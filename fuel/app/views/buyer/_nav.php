<script type="text/javascript">
$(function(){
	var $dialog = $('<div></div>')
		.html('Are you sure you want to delete this buyer?')
		.dialog({
			autoOpen: false,
			title: "Deleting buyer: <?=$buyer->name;?>",
			modal: true,
		    buttons: {
		        "Yes": function () {
					location.href="<?= Uri::create('buyer/delete/'.$buyer->id); ?>";
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
		<h6>Viewing Buyer: <?= $buyer->name; ?></h6>
		<div class="clear"></div>
	</div>

    <div class="formRow">
		<ul class="middleFree" style="margin-top: 0px;">
            <li><a href="<?= Uri::create('buyer/view/'.$buyer->id); ?>" class="bBlue"><span class="iconb" data-icon=""></span><span>Details</span></a></li>
            <li><a href="<?= Uri::create('buyer/edit/'.$buyer->id); ?>" class="bGreen"><span class="iconb" data-icon=""></span><span>Edit</span></a></li>
			<li><a href="<?= Uri::create('file/buyer/'.$buyer->id); ?>" class="bGold"><span class="iconb" data-icon=""></span><span>Files</span></a></li>
            <li style="width: 100px;"><a href="<?= Uri::create('buyer/find_yachtshares/'.$buyer->id); ?>" class="bLightBlue"><span class="iconb" data-icon=""></span><span>Find Yachts</span></a></li>
            <li><a href="#" class="bRed" id="opener"><span class="iconb" data-icon=""></span><span>Delete</span></a></li>
        </ul>
	</div>
</div>
