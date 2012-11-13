<script type="text/javascript">
$(document).ready(function(){
	$("#create_form").validate
	({
		errorPlacement: function(error, element)
		{
			if (element.attr("name") != "share_1_num" )
				error.insertAfter(element);
		}
	});

		//If a text input has been changed
		$("input[type='text']").keyup( function() { has_form_input_changed_since_last_save = true; });
		//If a text area has been changed
		$("textarea").keyup( function() { has_form_input_changed_since_last_save = true; });
		//If a dropdown has been changed
		$("select").change( function() { has_form_input_changed_since_last_save = true; });


	var preventUnloadPrompt;
	var messageBeforeUnload = "Closing this browser will mean that all the data you entered is lost. If you want to close the browser without loosing the data you have entered press 'Save for later' at the bottom of the form.";

	//var redirectAfterPrompt = "http://www.google.co.in";
	$('a').live('click', function() { preventUnloadPrompt = true; });
	$('form').live('submit', function() { preventUnloadPrompt = true; });

	$(window).bind("beforeunload", function(e) { 
		var rval;
		if(has_form_input_changed_since_last_save)
		{
			if(preventUnloadPrompt) {
				return;
			} else {
				//location.replace(redirectAfterPrompt);
				return messageBeforeUnload;
			}
			return rval;
		}
	})
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

</script>
<br>

<div class="widget fluid" style="width: 75%;">
    <div class="whead">
		<h6>New Yacht Share</h6>
		<div class="clear"></div>
	</div>

<form action="<?= Uri::create('yachtshare/create'); ?>" method="POST" accept-charset="utf-8" id="create_form">
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
		<?= render('forms/_terms_and_conditions',array('field'=>$field),false); ?>
	<? elseif($field->tag == 'share_size'): ?>

		<? if($yachtshare->temp): ?>
			<div class="formRow">
				<div class="grid3"><label>Share Size:</label></div>
				<div class="grid9" align="left">
						<input type='text' name="share_size>_num" style='width: 45px;' class="required number" /> / <input type='text' name="share_size_den" style='width: 45px;' class="required number" />
				</div>
				<div class="clear"></div>
			</div>
		<? else: ?>
			<div class="formRow">
				<div class="grid3"><label>Share Size:</label></div>
				<div class="grid9" align="left">
					Number of Shares: 
					<select class='' onchange="select_shares(this.value)" id="select_share">
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
