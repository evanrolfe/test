<script type="text/javascript">
$(document).ready(function(){
	$("#create_form").validate({
    errorPlacement: function(error, element) {
       if (element.attr("name") != "share_1_num" )
         error.insertAfter(element);
     }
  });
});

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

function save_form()
{
	var saved_form = $("#create_form").serializeArray();

	var request = $.ajax({
		url: "<?=Uri::create('session/save_form');?>",
		type: "POST",
		data: { form : saved_form},
		success: function(data) {
			$("#text_bar").html(data);
			$("#text_bar2").html(data);
			//setTimeout(function(){ save_form(); },3000);
		}
	});
}

</script>
<br>

<div class="widget fluid" style="width: 75%;">
    <div class="whead">
		<h6>New Yacht Share</h6>
		<div class="clear"></div>
	</div>

<form action="<?= Uri::create('yachtshare/update/'.$yachtshare->id); ?>" method="POST" accept-charset="utf-8" id="create_form">
<input type="hidden" name="user_id" value="<?= $user->id; ?>">
<input type="hidden" name="insert" value="1">
<input type="hidden" name="form_type" value="yachtshare">
<input type="hidden" name="temp" value="<?= $yachtshare->temp; ?>">
<input type="hidden" name="yachtshare_id" value="<?= $yachtshare->id; ?>">

<? foreach($formfields as $field): ?>

	<? if($field->type == 'text'): ?>
		<?= render('forms/_text',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'dropdown'): ?>
		<?= render('forms/_dropdown',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'textarea'): ?>
		<?= render('forms/_textarea',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'length'): ?>
		<?= render('forms/_length',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'terms_and_conditions'): ?>

	<? elseif($field->tag == 'share_size'): ?>

		<div class="formRow">
			<div class="grid3"><label>Share Size:</label></div>
			<div class="grid9" align="left">
					<input type='text' name="share_size_num" style='width: 45px;' class="required number" value="<?= $yachtshare->share_size_num; ?>"/> / <input type='text' name="share_size_den" style='width: 45px;' class="required number" value="<?=$yachtshare->share_size_den?>" />
			</div>
			<div class="clear"></div>
		</div>
	<? endif; ?>
<? endforeach; ?>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<span id="text_bar2">
			</span>
			<button class="buttonS bBlue tipS" style="margin: 6px 6px;" type="submit" name="save_for_later" original-title="Click here if you want to finish the form later.">Save for Later</button>
			<button class="buttonS bGreen tipS" style="margin: 6px 6px;" type="submit" name="submit" original-title="Click here to finalize and submit the yacht share.">Submit</button>
		</div>
		<div class="clear"></div>
	</div>
</div>
