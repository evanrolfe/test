<script type="text/javascript">
var submitClicked = false;
var has_form_input_changed_since_last_save = false;

function normalizeNewlines(input)
{
    return input;//.replace(/(\r\n|\r|\n)/g, '\r\n');
}
/*--------------------------------------------
 | Has the form been changed?
 *--------------------------------------------
 |
 | Prompt the user on exit/refresh if:
 |
 | 1. The form has been automatically filled out with the details of another boat (even if no changes have been made by user)
 | 		i.e. /yachtshare/create/1
 | 2. A change in one of the form fields has been made by the user
 */

var yachtshares = <?=json_encode($yachtshares_for_json);?>;

$(document).ready(function(){
	var shares = <?= json_encode($yachtshares_titles_for_json); ?>;
	var shares_lookup = <?= json_encode($yachtshares_titles_for_json); ?>;

	$( "#search_yachtshares" ).autocomplete({
		source: shares,

	});	

	$("#select_yachtshares_button").click(function(){
		$("#clear_form_button").show();

		var name_make = $("#search_yachtshares").val();

		var form_data = yachtshares[name_make];

		has_form_input_changed_since_last_save = true;

		//When copying over templates, the formfields with tags in this array will be skipped
		var excluded_fields = ["name","type","location_general","location_specific","lying","price"];
		var exclude_str = "*";

		for(var tag in form_data)
		{
			if(form_data['name'].charAt(0)==exclude_str)
			{
				if($.inArray(tag,excluded_fields)==-1)
				{
					$("input[name="+tag+"]").val(form_data[tag]);
					$("select[name="+tag+"]").val(form_data[tag]);
					$("textarea[name="+tag+"]").text(normalizeNewlines(form_data[tag]));
				}
			}else{
				$("input[name="+tag+"]").val(form_data[tag]);
				$("select[name="+tag+"]").val(form_data[tag]);
				$("textarea[name="+tag+"]").text(normalizeNewlines(form_data[tag]));				
			}	
		}

		$("#clear_form_button").show();		//DEPRACATED
	});

	var $dialog = $('<div></div>')
		.html('Are you sure you want to submit this yacht share? You cannot edit the form once it’s submitted.')
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

	jQuery.validator.addMethod("notEqual", function(value, element, param) {
	  return this.optional(element) || value != param;
	}, "Error: 0/0 is not a defined number!");


	$("#create_form").validate({
		rules: {
			share_1_num : { notEqual : 0 },
			share_1_den : { notEqual : 0 }			
		},
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

	var preventUnloadPrompt=false;
	var messageBeforeUnload = 'You have unsaved data! If you wish to save that data, please select "Stay on this page", then click the blue "Save and keep working" button before closing the browser.';

	//var redirectAfterPrompt = "http://www.google.co.in";
	$('form').live('submit', function() { preventUnloadPrompt = true; });

	$(window).bind("beforeunload", function(e) { 
		if(has_form_input_changed_since_last_save)
		{
			if(preventUnloadPrompt) {
				return;
			} else {
				//location.replace(redirectAfterPrompt);
				return messageBeforeUnload;
			}
		}
	});

	//AUTOSAVE STARTS IN 2 MINUTE
	setTimeout(function(){ save_form(); },5*60*1000);		

	//DISPLAY TIME AGO (from last save)
	jQuery("abbr.timeago").timeago();
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

function clear_form()
{
	var $clear_dialog = $('<div></div>')
		.html('Are you sure you want to clear the entire form?')
		.dialog({
			autoOpen: false,
			title: "Clearing the form",
			modal: true,
			width: 300,
			buttons: {
			    "No": function () {
			        $(this).dialog("close");
			    },					
			    "Yes, I'm sure.": function () {
			        $(this).dialog("close");			    	
					$("input[type=text], select").val("");
					$("textarea").html("");
			    }								
			}
		});

	$clear_dialog.dialog('open');
}

function save_form(display_results)
{
	//Set the default value of display_results to true
	display_results = true;//typeof display_results !== 'undefined' ? display_results : true;	

	var saved_form = $("#create_form").serializeArray();

	var request = $.ajax({
		url: "<?=Uri::create('session/save_form');?>",
		type: "POST",
		data: {
			form : saved_form,
			type : 'yachtshare'
		},
		success: function(isotimestamp) {
			$(".never_saved").hide();
			$(".timeago").attr("title", isotimestamp).data("timeago",null).timeago();

			setTimeout(function(){ save_form(); },2*60*1000);	//Autosave every 2 minutes
			has_form_input_changed_since_last_save = false;
		},
		failure: function() {
			alert("Error: your form could not be saved!");
		}
	});
}
</script>
<div class="widget fluid" style="width: 75%;">

    <div class="whead">
		<h6>Instructions</h6>	
		<div class="clear"></div>
	</div>

	<div class="formRow" align="left">
		Please complete this form as fully as possible, noting that:
		<ul class="liTip">
			<li>Questions marked with a red star are required</li>
			<li>The form will be automatically saved to your computer every two minutes and also when you click the button "Save and keep working"</li>
			<li>You can exit the form and complete it later using the same computer and browser. Press CTRL + D on the keyboard to add this form to your favorites so you can access it later</li>
			<li>After clicking submit, you will be able to upload photos and documents </li>	
			<li>Should you need to makes any changes after the form has been submitted, please contact Chris Hawes - <a href="mailto:chris@yachtfractions.co.uk">chris@yachtfractions.co.uk</a> (Tel: 01326 374435)</li>
			<li>Your entry will be published to the Yacht Fractions website after it has been reviewed by the administrator</li>
		</ul>
	</div>	
</div>

<div class="widget fluid" style="width: 75%;">

    <div class="whead">
		<h6>Save time with our autocomplete feature</h6>		
		<div class="clear"></div>
	</div>

	<div class="formRow">
		<div align="left">
			We may already have the details of your yacht in our database. Just type in the name or model (e.g. "Bavaria 36" or "Titanic"): if your boat shows up, click on the name and then click on "Copy this boat to form".
		</div>
			<div class="searchLine" style="width: 500px;">
				<input type="text" id="search_yachtshares" placeholder="Enter the make/model of your boat..." autocomplete="off">
				<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
				
			</div>
			<br>
			<button class="buttonS bGold" id="select_yachtshares_button" type="button">Copy this boat to form</button>
		<div class="clear"></div>		
	</div>	

</div>

<div class="widget fluid" style="width: 75%;">
    <div class="whead">
		<h6>Yacht Share Details Form</h6>

		<div style='text-align: right;'>
			Last saved: <span class="never_saved">not saved.</span><span class="timeago"></span>
			<button class="buttonS bBlue tipS cancel" style="margin: 6px 6px;" type="button" onclick="save_form()" original-title="Click here if you want to finish the form later.">Save and keep working</button>
		</div>				
		<div class="clear"></div>
	</div>

<form action="<?= Uri::create('yachtshare/create'); ?>" method="POST" accept-charset="utf-8" id="create_form">
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
			<div class="grid3"><label>Share Size<font color="red">*</font>:</label></div>
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
			Last saved: <span class="never_saved">not saved.</span><span class="timeago"></span>
			<button class="buttonS bBlue tipS cancel" style="margin: 6px 6px;" type="button" onclick="save_form()" original-title="Click here if you want to finish the form later.">Save and keep working</button>
			<button class="buttonS bGreen tipS" style="margin: 6px 6px;" type="button" original-title="Click here to finalize and submit the yacht share." id="create_form_submit" onclick="submitClicked=true;">Submit</button>
		</div>
		<div class="clear"></div>
	</div>
</div>
