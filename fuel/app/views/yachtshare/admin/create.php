<script type="text/javascript">
$(document).ready(function(){
	$("#create_form").validate({
		rules : { test : "required"}
	});
});
</script>
<form action="<?= Uri::create('yachtshare/handle_post'); ?>" method="POST" accept-charset="utf-8" id="create_form">
<input type="hidden" name="user_id" value="<?= $user->id; ?>">
<input type="hidden" name="insert" value="1">
<div class="widget fluid">

    <div class="whead">
		<h6>New Yacht Share</h6>
		<div class="clear"></div>
	</div>
<? foreach($formfields as $field): ?>

	<? if($field->type == 'text'): ?>
		<?= render('forms/_text',array('field'=>$field,'value'=>''),false); ?>
	<? elseif($field->type == 'dropdown'): ?>
		<?= render('forms/_dropdown',array('field'=>$field,'value'=>''),false); ?>
	<? elseif($field->type == 'textarea'): ?>
		<?= render('forms/_textarea',array('field'=>$field,'value'=>''),false); ?>
	<? elseif($field->type == 'length'): ?>
		<?= render('forms/_length',array('field'=>$field,'value'=>''),false); ?>
	<? elseif($field->tag == 'share_size'): ?>
<div class="formRow">
        <div class="grid3"><label>Share Size:</label></div>
        <div class="grid9 noSearch" align="left">
			<select class='select required' onchange="select_shares(this.value)" id="select_share">
				<option value="">Number of Shares</option>
				<? for($i=1; $i<=10; $i++): ?>
					<option value="<?= $i; ?>"><?= $i; ?></option>
				<? endfor; ?>
			</select>

			<? for($i=1; $i<=10; $i++): ?>
				<div id="share_<?= $i; ?>" <? if($i>1):?>style="display: none;"<?endif;?>>Share #<?= $i; ?> <input type='text' name="share_<?= $i; ?>_num" style='width: 45px;' class="required number" /> / <input type='text' name="share_<?= $i; ?>_den" style='width: 45px;' class="required number" /></div>
			<? endfor; ?>
		</div>
        <div class="clear"></div>
    </div>
	<? endif; ?>

<? endforeach; ?>

<script type="text/javascript">
function select_shares(n)
{
	for(var i=1; i<=10; i++)
	{
		$("#share_"+i).hide();
	}

	for(var i=1; i<=n; i++)
	{
		$("#share_"+i).show();
	}
}

</script>

    

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Save</button>
		</div>
		<div class="clear"></div>
	</div>

</div>
</form>
