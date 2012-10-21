<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>Yacht Fractions</title>
	<?php echo render('_includes'); ?>
</head>
<body>
<?php echo render('_flash_messages'); ?>
<script type="text/javascript">
$(function(){
	var uploader = $("#uploader").pluploadQueue({
		runtimes : 'html5,html4',
		url : "<?= Uri::create('/image/upload/'.$yachtshare->id); ?>",
		max_file_size : '1000kb',
		unique_names : true,
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"}
		]
	});

	uploader.bind('FileUploaded', function(up, file, res){
		alert("Uploaded.");
	});
});
</script>

<div style="width: 100%;" align="center">
<div class="widget fluid" style="width: 600px;">
    <div class="whead"><h6>Images</h6><div class="clear"></div></div>
	<?= render('image/_row', array('images' => $yachtshare->images)); ?>
</div>

<div class="widget fluid" style="width: 600px;">
    <div class="whead"><h6>Multiple files uploader</h6><div class="clear"></div></div>
    <div id="uploader" style="position: relative; "><div class="plupload_wrapper plupload_scroll"><div id="uploader_container" class="plupload_container" title="Using runtime: html5"><div class="plupload"><div class="plupload_header"><div class="plupload_header_content"><div class="plupload_header_title">Select files</div><div class="plupload_header_text">Add files to the upload queue and click the start button.</div></div></div><div class="plupload_content"><div class="plupload_filelist_header"><div class="plupload_file_name">Filename</div><div class="plupload_file_action">&nbsp;</div><div class="plupload_file_status"><span>Status</span></div><div class="plupload_file_size">Size</div><div class="plupload_clearer">&nbsp;</div></div><ul id="uploader_filelist" class="plupload_filelist"><li class="plupload_droptext">Drag files here.</li></ul><div class="plupload_filelist_footer"><div class="plupload_file_name"><div class="plupload_buttons"><a href="#" class="plupload_button plupload_add buttonS bDefault" id="uploader_browse" style="position: relative; z-index: 0; ">Add files</a><a href="#" class="plupload_button plupload_start buttonS bBlue plupload_disabled">Start upload</a><div class="clear"></div></div><span class="plupload_upload_status"></span></div><div class="plupload_file_action"></div><div class="plupload_file_status"><span class="plupload_total_status">0%</span></div><div class="plupload_file_size"><span class="plupload_total_file_size">0 b</span></div><div class="plupload_progress"><div class="plupload_progress_container"><div class="plupload_progress_bar"></div></div></div><div class="plupload_clearer">&nbsp;</div></div></div></div></div><input type="hidden" id="uploader_count" name="uploader_count" value="0"></div><div id="p173rdef0541r1r0pju81j53okg0_html5_container" style="position: absolute; background-color: transparent; overflow: hidden; opacity: 0; top: 225px; left: 12px; width: 77px; height: 28px; z-index: -1; background-position: initial initial; background-repeat: initial initial; " class="plupload html5"><div class="uploader" id="uniform-p173rdef0541r1r0pju81j53okg0_html5"><input id="p173rdef0541r1r0pju81j53okg0_html5" style="font-size: 999px; position: absolute; width: 100%; height: 100%; opacity: 0; " type="file" accept="image/jpeg,image/gif,image/png" multiple="multiple" size="24"><span class="filename">No file selected</span><span class="action">Choose File</span></div></div></div>                    
</div>
<a href="<? Uri::create('session/logout'); ?>">Logout</a>
</div>
