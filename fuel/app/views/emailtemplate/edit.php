<form action="<?= Uri::create('emailtemplate/edit/'.$emailtemplate->id); ?>" method="POST" accept-charset="utf-8">
<script type="text/javascript">
function insert_var(val)
{
	$("#body").val($("#body").val()+val);
}
</script>
<div class="widget fluid">

    <div class="whead"><h6>Edit Email Template</h6><div class="clear"></div></div>

    <div class="formRow">
        <div class="grid3"><label>Subject:</label></div>
        <div class="grid9">
			<input type="text" name="subject" value="<?=$emailtemplate->subject;?>" />
		</div>
        <div class="clear"></div>
	</div>

    <div class="formRow">
		You may use the following variables in the body:<br>
		<? foreach($tags as $tag): ?><?= substr($tag,1,strlen($tag)-2); ?>, <? endforeach; ?>
		<a href="#" onclick="insert_var('<buyer_name>')">buyer_name</a>
        <div class="clear"></div>
	</div>

    <div class="formRow" id="note">
        <div class="grid3"><label>Body:</label></div>
        <div class="grid9"><textarea rows="14" cols="" name="body" id="body"><?= $emailtemplate->body; ?></textarea></div>
        <div class="clear"></div>
    </div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Save</button>
		</div>
		<div class="clear"></div>
	</div>

</div>
</form>
