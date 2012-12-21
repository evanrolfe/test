<script type="text/javascript">
$(function(){

});
</script>

<div class="widget fluid" style="width: 75%;">
    <div class="whead">
		<h6>Instructions</h6>
		<div class="clear"></div>
	</div>

	<div class="formRow">
		<div align="left">
			Here you can upload photographs or documents relating to your yacht. Good photographs greatly enhance your listing.
			<ol>
				<li>Click the [+] button to select a file from your computer</li>
				<li>Select the type of file that this represents</li>
				<li>Click UPLOAD - this may take a minute or two</li>
			</ol>
			Repeat the process for additional files.		
		</div>
		<div class="clear"></div>
	</div>	
</div>

<form action="<?= Uri::create('file/upload'); ?>" method="POST" enctype="multipart/form-data" id="upload_form">
<input type="hidden" name="belongs_to_id" value="<?=$item->id;?>" />
<input type="hidden" name="belongs_to" value="<?=$type;?>" />

<div class="widget fluid" style="width: 75%;">
    <div class="whead">
		<h6>Files</h6>
		<div align="right">
			<a href="<?=Uri::Create($type.'/view/'.$item->id);?>"><button class="buttonS bBlue" style="margin: 6px 6px;" type="button">Finish Yachtshare Submission</button></a>
		</div>
		<div class="clear"></div>
	</div>

	<? if(count($files) > 0): ?>
	<div class="formRow">
			<? foreach($files as $file): ?>
				<a href="<?=Uri::create('public/uploads/'.$file->url);?>" target="_blank"><?= $file->url; ?></a><br>
			<? endforeach; ?>
		 <div class="clear"></div>
	</div>
	<? endif; ?>

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

	<div class="formRow">
		<div class="grid3">&nbsp;
		</div>
		<div class="grid9" align="left">
			<ul class="liInfo">
				<li>Private document or photo – this will not be published to the website (e.g. survey, share agreement or insurance policy)</li>
				<li>Public header photo for the website - this will be the main photograph that is displayed with your yacht’s listing</li>
				<li>Public gallery photo – additional images that will be displayed in the detailed listing</li>
			<ul>
		</div>
	   <div class="clear"></div>		
	</div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right; margin: 6px 6px; display: none;' id="loading">		
			<img src="<?=Uri::create('public/assets/images/elements/loaders/4s.gif');?>"/>Please wait while your file uploads.
		</div>
		<div style='text-align: right;' id="submit_div">
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit" onclick="$('#loading').show();$('#submit_div').hide();">Upload</button>
		</div>
		<div class="clear"></div>
	</div>
</div>

</form>
