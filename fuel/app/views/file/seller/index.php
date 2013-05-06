<script type="text/javascript">
$(function(){

});
</script>

<div class="widget fluid" style="width: 75%;">
 

<form action="<?= Uri::create('file/upload'); ?>" method="POST" enctype="multipart/form-data" id="upload_form">
<input type="hidden" name="belongs_to_id" value="<?=$item->id;?>" />
<input type="hidden" name="belongs_to" value="<?=$type;?>" />
<p>&nbsp; </p>
<h3>Photographs</h3>
<div class="widget fluid" style="width: 75%;">
    <div class="whead">
		<h6>Upload Photographs and Files Here</h6>
		<div class="clear"></div>
	</div>



	<div class="formRow">
		<div class="grid3" align="left">
		  <label>1. Click the [+] button to select a file from your computer</label></div>
		<div class="grid9" align="left">
			<input type='file' name="file" class="required"/>
		</div>
		<div class="clear"></div>
	</div>

  <div class="formRow">
      <div class="grid3" align="left"><label>2. What type of file or photo is this?</label>
        </div>
      <div class="grid9" align="left">
		  <select name="type" class="required">
        		<option value="">Select</option>
				<option value="public_gallery">An additional gallery photo for website listing (public)</option>
                <option value="public_header">The main photo for website listing (public)</option>
            <option value="private">Private document or photo</option>
				
	    </select>
	  </div>
	   <div class="clear"></div>
  </div>

	<div class="formRow">
		<div class="grid3" align="left">3. Click the green UPLOAD button and repeat the process for other photos.
		</div>
		<div class="grid9" align="left">
			
		</div>
	   <div class="clear"></div>		
	</div>
	<div class="formRow">
		<div class="grid9" align="left">4. When done with the photos, click the blue button to finish.
		</div>
		<div class="grid9" align="left">
	<div class="whead">
    
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right; margin: 6px 6px; display: none;' id="loading">		
			<img src="<?=Uri::create('public/assets/images/elements/loaders/4s.gif');?>"/>Please wait while your file uploads.
		</div>
		<div style='text-align: center;' id="submit_div">
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit" onclick="$('#loading').show();$('#submit_div').hide();">Upload</button>
			<a href="<?=Uri::Create($type.'/view/'.$item->id);?>" class="buttonS bBlue" style="margin: 6px 6px; color: white;" >Finish Yachtshare Submission</a>
		</div>
		<div class="clear"></div>
	</div>
</div>
</div>
</div>

</form>

<p>&nbsp; </p>
<p>&nbsp; </p>

<div class="widget fluid" style="width: 75%;">
 <div class="whead">
		<h6>Files Already Uploaded</h6>
		<div class="clear"></div>
	</div>

	<? if(count($files) > 0): ?>
	<div class="formRow">
			<? foreach($files as $file): ?>
				
                <table width="400" border="1" align="left">
                  <tr align="left" valign="top">
                    <td><img src="<?=Uri::create('public/uploads/'.$file->url);?>" height="100" /></td>
                    <td></a>  <a href="<?=Uri::create('public/uploads/'.$file->url);?>" target="_blank"><?= $file->url; ?></a></td>
                    </tr>
                </table>
                </td>
                
                
			<? endforeach; ?>
            <p>&nbsp; </p>
		 <div class="clear"></div>
</div>
</div>
</div>
	<? endif; ?>
    
