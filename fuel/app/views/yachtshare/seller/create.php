<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
</head>
	<?php echo render('_includes'); ?>
<?php echo render('_flash_messages'); ?>
<script type="text/javascript">
$(document).ready(function(){
	$("#create_form").validate({
		rules : {
			password2 : { equalTo : "#password"}
		},
		messages : {
			password2 : "This password must match the one in the previous field."
		}
	});
});

function save_form()
{
	var saved_form = $("#create_form").serializeArray();

	var request = $.ajax({
		url: "<?=Uri::create('session/save_form');?>",
		type: "POST",
		data: { form : saved_form},
		success: function(data) {
			$("#text_bar").html(data);
			//setTimeout(function(){ save_form(); },5000);
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			alert("Error:\n Status: "+textStatus+"\nError Thrown: "+errorThrown);	
		}
	});
}
</script>

<form action="<?= Uri::create('yachtshare/handle_post'); ?>" method="POST" accept-charset="utf-8" id="create_form">
<input type="hidden" name="user_id" value="<?= $user->id; ?>">
<input type="hidden" name="insert" value="1">
<input type="hidden" name="form_type" value="yachtshare">

<div align="center">
<div class="widget fluid" style="width: 70%;">

    <div class="whead">
		<h6>New Yacht Share</h6>
		<div style="text-align: right">
<span id="text_bar">
</span> 	
			<button class="buttonS bGreen" style="margin: 6px 6px;" onclick="save_form()" type="button">Save for Later</button>
		</div>	
		<div class="clear"></div>
	</div>
<? foreach($formfields as $field): ?>

	<? if($field->type == 'text'): ?>
		<?= render('forms/_text',array('field'=>$field,'value'=>$saved_form_data[$field->tag])); ?>
	<? elseif($field->type == 'dropdown'): ?>
		<?= render('forms/_dropdown',array('field'=>$field,'value'=>$saved_form_data[$field->tag])); ?>
	<? elseif($field->type == 'textarea'): ?>
		<?= render('forms/_textarea',array('field'=>$field,'value'=>$saved_form_data[$field->tag])); ?>
	<? elseif($field->type == 'length'): ?>
		<?= render('forms/_length',array('field'=>$field,'value'=>$saved_form_data[$field->tag])); ?>
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
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Save</button>
		</div>
		<div class="clear"></div>
	</div>

</div>
<a href="<? Uri::create('session/logout'); ?>">Logout</a>
</div>
</form>
<br>
