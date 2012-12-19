<script type="text/javascript">
$(function(){
	$("#upload_form").validate();
});
</script>
<div class="widget fluid" style="width: 450px;">
    <div class="whead">
		<h6>Files</h6>
		<div align="right">
			<a href="<?=Uri::Create($type.'/view/'.$item->id);?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button">Finish Yachtshare Submission</button></a>
		</div>
		<div class="clear"></div>
	</div>

	<div class="formRow">
		<? if(count($files) > 0): ?>
			<? foreach($files as $file): ?>
				<a href="<?=Uri::create('public/uploads/'.$file->url);?>" target="_blank"><?= $file->url; ?></a><br>
			<? endforeach; ?>
		<? else: ?>
			There are no files uploaded for this <?=$type; ?>.
		<? endif; ?>
		 <div class="clear"></div>
	</div>
</div>

<form action="<?= Uri::create('file/upload'); ?>" method="POST" enctype="multipart/form-data" id="upload_form">

  <input type="hidden" name="belongs_to_id" value="<?=$item->id;?>" />
  <input type="hidden" name="belongs_to" value="<?=$type;?>" />
  <div class="widget fluid" style="width: 450px;">
      <div class="whead">
		  <h6>Upload File</h6>
		  <div class="clear"></div>
	  </div>

	  <div class="formRow">
	      <div class="grid3"><label>Select a File:</label></div>
	      <div class="grid9" align="left">
			  <input type='file' name="file" class="required"/>
		  </div>
		   <div class="clear"></div>
	  </div>

	  <div class="formRow">
	      <div class="grid3"><label>File Type:</label></div>
	      <div class="grid9" align="left">
			  <select name="type" class="required">
            		<option value="">Select</option>
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
