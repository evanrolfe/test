<form action="<?= Uri::create('emailnew/create'); ?>" method="POST" accept-charset="utf-8">
<input type="hidden" name="template_id" value="<?=$template->id; ?>">
<input type="hidden" name="from_page" value="<?=$from_page; ?>">
<?if(isset($yachtshare)):?><input type="hidden" name="yachtshare_id" value="<?=$yachtshare->id;?>"><?endif;?>
<?if(isset($buyer)):?><input type="hidden" name="buyer_id" value="<?=$buyer->id;?>"><?endif;?>
<div class="widget fluid">

    <div class="whead"><h6>New Email</h6><div class="clear"></div></div>

    <div class="formRow">
        <div class="grid3"><label>To:</label></div>
        <div class="grid9">
			<input type="text" name="to" value="<?=$to;?>"/>
		</div>
        <div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>Subject:</label></div>
        <div class="grid9">
			<input type="text" name="subject" value="<?=$subject;?>" />
		</div>
        <div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>Attachments:</label></div>
        <div class="grid9">
			<? foreach($attachments as $file): ?>
				<input type="checkbox" name="file_<?=$file->id;?>" checked="yes"> <a href="<?=Uri::create('public/uploads/'.$file->url);?>"><?= $file->url; ?></a><br>
			<? endforeach; ?>
		</div>
        <div class="clear"></div>
	</div>

    <div class="formRow" id="note">
        <div class="grid3"><label>Body:</label></div>
        <div class="grid9"><textarea rows="14" cols="" name="body"><?= $body; ?></textarea></div>
        <div class="clear"></div>
    </div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Send</button>
		</div>
		<div class="clear"></div>
	</div>

</div>

</form>
