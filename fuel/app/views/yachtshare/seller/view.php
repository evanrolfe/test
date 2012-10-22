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
<div align="center">

<div class="widget fluid" style="width: 70%;">

    <div class="whead">
		<h6>Details</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('yachtshare/edit/'.$yachtshare->id); ?>"><button class="buttonS bGreen" style="margin: 6px 6px;">Edit</button></a>
			<a href="#" id="opener"><button class="buttonS bRed" style="margin: 6px 6px;">Delete</button></a>
			<a href="<?= Uri::create('seller'); ?>"><button class="buttonS bBlue" style="margin: 6px 6px;">Back</button></a>
		</div>
		<div class="clear"></div>
	</div>

	<? foreach($formfields as $field): ?>
    <div class="formRow">
        <div class="grid3"><label><?= $field->label; ?>:</label></div>
        <div class="grid9" align="left">
			<? if($field->search_field): ?>
				<? $tag = $field->tag; ?>
				<?= $yachtshare->$tag;?>
			<? else: ?>
				<?= str_replace("\n", "<br>", $yachtshare->boat_details[$field->tag]); ?>
			<? endif; ?>
		</div>
        <div class="clear"></div>
    </div>
	<? endforeach; ?>

</div>
<br>
