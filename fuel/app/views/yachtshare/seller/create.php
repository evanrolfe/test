<script type="text/javascript">
var submitClicked = false;

/*--------------------------------------------
 | Has the form been changed?
 *--------------------------------------------
 *
 * Prompt the user on exit/refresh if:
 *
 * 1. The form has been automatically filled out with the details of another boat (even if no changes have been made by user)
 * 		i.e. /yachtshare/create/1
 * 2. A change in one of the form fields has been made by the user
 */


$(document).ready(function(){
	var $dialog = $('<div></div>')
		.html('Are you sure you want to submit this yachtshare? Once you have submitted you cannot make any more changes.')
		.dialog({
			autoOpen: false,
			title: "Are you sure?",
			modal: true,
			width: 600,
			buttons: {
			    "No, go back to editing the form.": function () {
			        $(this).dialog("close");
			    },					
			    "Yes, I'm sure. Submit the form.": function () {
			        $(this).dialog("close");			    	
			        $("#create_form").submit();
			    }								
			}
		});

	$('#create_form_submit').click(function() {
		$dialog.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});

	$("#create_form").validate({
		errorPlacement: function(error, element)
		{
			if (element.attr("name") != "share_1_num" )
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

		//If a text input has been changed
		$("input[type='text']").keyup( function() { has_form_input_changed_since_last_save = true; });
		//If a text area has been changed
		$("textarea").keyup( function() { has_form_input_changed_since_last_save = true; });
		//If a dropdown has been changed
		$("select").change( function() { has_form_input_changed_since_last_save = true; });

		//If this a creating a new yachtshare from an already created one, we must assume the user wiill want ot save the changes
		if(<?= (($form['name']) == '') ? "false" : "true"; ?>)
			has_form_input_changed_since_last_save = true;

	var preventUnloadPrompt;
	var messageBeforeUnload = "Closing this browser will mean that all the data you entered is lost. If you want to close the browser without loosing the data you have entered press 'Save for later' at the bottom of the form and your data will remain there when you come back.";

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
	});

	save_form(false);	
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

function save_form(display_results)
{
	//Set the default value of display_results to true
	display_results = typeof display_results !== 'undefined' ? display_results : true;	

	var saved_form = $("#create_form").serializeArray();

	var request = $.ajax({
		url: "<?=Uri::create('session/save_form');?>",
		type: "POST",
		data: {
			form : saved_form,
			type : 'yachtshare'
		},
		success: function(data) {
			if(display_results)
			{	
				$("#text_bar").html(data);
				$("#text_bar2").html(data);
			}
			setTimeout(function(){ save_form(); },2*60*1000);	//Autosave every 2 minutes
			has_form_input_changed_since_last_save = false;
		}
	});
}
</script>
<br>

<div class="widget fluid" style="width: 75%;">
    <div class="whead">
		<h6>New Yacht Share</h6>
		<div style='text-align: right; padding: 8px 14px 7px 14px;' id='text_bar'>
		</div>		
		<div class="clear"></div>
	</div>

<form action="<?= Uri::create('yachtshare/create_new'); ?>" method="POST" accept-charset="utf-8" id="create_form">
<!-- <input type="hidden" name="user_id" value="<?= $user->id; ?>"> -->
<input type="hidden" name="insert" value="1">
<input type="hidden" name="form_type" value="yachtshare">

<? foreach($formfields as $field): ?>

	<? if($field->type == 'text'): ?>
		<?= render('forms/_text',array('field'=>$field,'value'=>$form[$field->tag]),false); ?>
	<? elseif($field->type == 'dropdown'): ?>
		<?= render('forms/_dropdown',array('field'=>$field,'value'=>$form[$field->tag]),false); ?>
	<? elseif($field->type == 'textarea'): ?>
		<?= render('forms/_textarea',array('field'=>$field,'value'=>$form[$field->tag]),false); ?>
	<? elseif($field->type == 'length'): ?>
		<?= render('forms/_length',array('field'=>$field,'value'=>$form[$field->tag]),false); ?>
	<? elseif($field->type == 'terms_and_conditions'): ?>
		<?= render('forms/_terms_and_conditions',array('field'=>$field),false); ?>
	<? elseif($field->tag == 'share_size'): ?>
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

<? endforeach; ?>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<span id="text_bar2">
			</span>
			<button class="buttonS bBlue tipS cancel" style="margin: 6px 6px;" type="button" onclick="save_form()" original-title="Click here if you want to finish the form later.">Save and keep working</button>
			<button class="buttonS bGreen tipS" style="margin: 6px 6px;" type="button" original-title="Click here to finalize and submit the yacht share." id="create_form_submit">Submit</button>
		</div>
		<div class="clear"></div>
	</div>
</div>
