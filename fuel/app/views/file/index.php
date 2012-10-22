<? if($type == 'yachtshare'): ?>
	<?= render('yachtshare/admin/_nav', array('yachtshare' => $item)); ?>
<? else: ?>
	<?= render('buyer/_nav', array('buyer' => $item)); ?>
<? endif; ?>

<div class="widget fluid">
    <div class="whead">
		<h6>Files</h6>
		<div class="clear"></div>
	</div>

	<div class="formRow">
		<? if(count($files) > 0): ?>
			<? foreach($files as $file): ?>

<script type="text/javascript">
$(function(){
	var $dialog = $('<div></div>')
		.html('Are you sure you want to this file?')
		.dialog({
			autoOpen: false,
			title: "Deleting File:",
			modal: true,
		    buttons: {
		        "Yes": function () {
					location.href="<?= Uri::create('file/delete/'.$file->id); ?>";
		        },
		        "No": function () {
		            $(this).dialog("close");
		        }
		    }
		});

	$('#file_<?=$file->id;?>').click(function() {
		$dialog.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
});
</script>

				<a href="#" id="file_<?=$file->id;?>">[X]</a>  <a href="<?=Uri::create('public/uploads/'.$file->url);?>" target="_blank"><?= $file->url; ?></a><br>
			<? endforeach; ?>
		<? else: ?>
			There are no files uploaded for this <?=$type; ?>.
		<? endif; ?>
		 <div class="clear"></div>
	</div>
</div>
</form>

<form action="<?= Uri::create('file/upload'); ?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="belongs_to_id" value="<?=$item->id;?>" />
<input type="hidden" name="belongs_to" value="<?=$type;?>" />
<div class="widget fluid">
    <div class="whead">
		<h6>Upload File</h6>
		<div class="clear"></div>
	</div>

	<div class="formRow">
	    <div class="grid3"><label>Select a File:</label></div>
	    <div class="grid9" align="left">
			<input type='file' name="file"/>
		</div>
		 <div class="clear"></div>
	</div>

	<div class="formRow">
	    <div class="grid3"><label>File Type:</label></div>
	    <div class="grid9 noSearch" align="left">
			<select class='select' name="type">
					<option value="private">Private document or photo</option>
					<option value="public_header">Public header photo for website</option>
					<option value="public_gallery">Public gallery photo for website</option>
			</select>
		</div>
		 <div class="clear"></div>
	</div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Upload</button>
		</div>
		<div class="clear"></div>
	</div>
</div>
</form>
