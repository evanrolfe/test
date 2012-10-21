<? foreach($images as $image): ?>
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
});
</script>
<? endforeach; ?>

<?= render('settings/_nav'); ?>

<?php if ($images): ?>

<div class="widget check">
    <div class="whead"><h6>Images</h6><div class="clear"></div></div>
    <table cellpadding="0" cellspacing="0" width="100%" class="tDefault checkAll tMedia" id="checkAll">
        <thead>
            <tr>
                <td class="50"><div>Thumbnail<span></span></div></td>
                <td width="130" class="sortCol header"><div>Date Added<span></span></div></td>
                <td width="120">Boat Name</td>
                <td width="100">Actions</td>
            </tr>
        </thead>
        <tbody>
		<? foreach($images as $image): ?>
            <tr>
                <td><img src="<?= Uri::create('public/uploads/'.$image->url); ?>" width="45"></td>
                <td class="textL"><?= date("H:i - d/m/Y",$image->created_at); ?></td>
                <td class="fileInfo"><span><a href="<?= Uri::create('boat/images/'.$image->belongs_to_id); ?>"><?= $image->boat->name; ?></a></span></td>
                <td class="tableActs">
                    <a href="#" class="tablectrl_small bDefault tipS" original-title="Edit"><span class="iconb" data-icon=""></span></a>
                    <a href="#" class="tablectrl_small bDefault tipS" original-title="Remove"><span class="iconb" data-icon=""></span></a>
                    <a href="#" class="tablectrl_small bDefault tipS" original-title="Options"><span class="iconb" data-icon=""></span></a>
                </td>
            </tr>
		<? endforeach; ?>
        </tbody>
    </table>
</div>

<?php else: ?>
<p>No Images.</p>

<?php endif; ?>
