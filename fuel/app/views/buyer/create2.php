<script type="text/javascript">
var shares = <?= $json_shares; ?>

var has_form_input_changed_since_last_save = false;
var submitClicked = false;

function select_share()
{
	id = $('#interested_boats').val();

	if(id)
	{
		$("#selected_shares").show();
		$("#selected_shares_content").append(shares[id]+"<br>");
		$("#boats_interest").val($("#boats_interest").val()+id+",");
	}
}

$(document).ready(function(){


	$('#create_form_submit').click(function() {
		submitClicked = true;
		$('#create_form').submit();    
		return false;
	});

	$("#create_form").validate({

		errorPlacement: function(error, element) {
			if (element.attr("name") != "max_share_size_num" &&  element.attr("name") != "min_share_size_num")
				error.insertAfter(element);
		},

		showErrors: function(errorMap, errorList) {
			this.defaultShowErrors();
			if (submitClicked && errorList.length > 0)
			{
				submitClicked = false;
				alert("Please complete the required fields before your form can be saved");
			}
		}	
	});

	//So this can be called from PHP. i.e. if a buyer has entered an already used email
	if(<?=$prompt_user_on_exit;?>)
		has_form_input_changed_since_last_save = true;

	//If a text input has been changed
	$("input[type='text']").keyup( function() {
		has_form_input_changed_since_last_save = true;
	});

	//If a text area has been changed
	$("textarea").keyup( function() {
		has_form_input_changed_since_last_save = true;
	});
	//If a dropdown has been changed
	$("select").change( function() {
		has_form_input_changed_since_last_save = true;
	});

		var preventUnloadPrompt;
		var messageBeforeUnload = "You have unsaved changes made to the form. Would you like to click 'Save for later' so you can come back to this form with your data still there?"
		//var redirectAfterPrompt = "http://www.google.co.in";
		$('a').live('click', function() { preventUnloadPrompt = true; });
		$('form').live('submit', function() { preventUnloadPrompt = true; });
		$(window).bind("beforeunload", function(e) { 

			//Only display the "are you sure" prompt if the form has been changed list last save
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

function save_form()
{
	var saved_form = $("#create_form").serializeArray();

	var request = $.ajax({
		url: "<?=Uri::create('session/save_form');?>",
		type: "POST",
		data: {
			form : saved_form,
			type : 'buyer'
		},
		success: function(data) {
			$("#text_bar").html(data);
			$("#text_bar2").html(data);
			setTimeout(function(){ save_form(); },2*60*1000);	//Autosave every 2 minutes
			has_form_input_changed_since_last_save = false;
		}
	});
}
</script>
<div class="widget fluid" style="width: 75%;">
    <div class="whead">
		<h6>Buyer Enquiry Form</h6>
		<div style='text-align: right; padding: 8px 14px 7px 14px;' id='text_bar'>
		</div>			
		<div class="clear"></div>
	</div>

<form action="<?= Uri::create('buyer/handle_post'); ?>" method="POST" accept-charset="utf-8" id="create_form">
<input type="hidden" name="insert" value="1" />
<? foreach($fields_search as $field): ?>

	<? if($field->type == 'text'): ?>
		<?= render('forms/_text',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'dropdown'): ?>
		<?= render('forms/_dropdown',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'textarea'): ?>
		<?= render('forms/_textarea',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'text_fraction'): ?>
		<?= render('forms/_text_fraction',array('field'=>$field,'value'=>array('num' =>$saved_form_data[$field->tag.'_num'],'den' => $saved_form_data[$field->tag.'_den'])),false); ?>
	<? elseif($field->type == 'length'): ?>
		<?= render('forms/_length',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'terms_and_conditions'): ?>
		<?= render('forms/_terms_and_conditions',array('field'=>$field),false); ?>

	<? elseif($field->type == 'other'): ?>
	<div class="formRow">
		    <div class="grid3"><label>Select three yachts which interest you:</label></div>
		    <div class="grid9 searchDrop" align="left">
				<select name="interest1" class="">
					<option value="">Select</option>
					<? foreach($yachtshares as $share): ?>
						<option value="<?= $share->id; ?>"><?= $share->make; ?> - "<?= $share->name; ?>"</option>
					<? endforeach; ?>
				</select>
				<br>
				<select name="interest2" class="">
					<option value="">Select</option>
					<? foreach($yachtshares as $share): ?>
						<option value="<?= $share->id; ?>"><?= $share->make; ?> - "<?= $share->name; ?>"</option>
					<? endforeach; ?>
				</select>
				<br>
				<select name="interest3" class="">
					<option value="">Select</option>
					<? foreach($yachtshares as $share): ?>
						<option value="<?= $share->id; ?>"><?= $share->make; ?> - "<?= $share->name; ?>"</option>
					<? endforeach; ?>
				</select>
			</div>
		    <div class="clear"></div>
		</div>

		<div class="formRow" id="selected_shares" style="display: none;">
			<div class="grid3"><label>Selected Boats</label></div>
			<div class="grid9" id="selected_shares_content" align="left">
			</div>
			<div class="clear"></div>
		</div>
	<? endif; ?>

<? endforeach; ?>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<span id="text_bar2">You will receive email confirmation after clicking submit. If this does not arrive, please check your junk email or contact Chris Hawes (contact listed below)</span>
            <button class="buttonS bBlue tipS" original-title="Click here and the data that you entered in the form will be saved so that you can close the browser and come back to this page later." style="margin: 6px 6px;" onclick="save_form()" type="button">Save for Later</button>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit" id="create_form_submit">Submit</button>
		</div>
	  <div class="clear"></div>
	</div>
</div>
</form>
