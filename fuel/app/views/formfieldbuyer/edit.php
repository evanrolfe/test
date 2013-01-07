<script type="text/javascript">
var changes_made = false;

function select_link(id)
{
	$(".dropdown_opt").hide();
	$("#dropdown_"+id).show();
}


var selected_options = [];
var options = [];

function add_option()
{
	changes_made = true;
	options.push($("#option_add_input").val());
	refresh_options();
}

function del_option(index)
{
	changes_made = true;
	options.splice(index,1);

	refresh_options();
}

function sort_alpha()
{
	options.sort();
	changes_made = true;	
	refresh_options();
}

function refresh_options()
{
	//2. Set input value as these options
	$("#options").val(JSON.stringify(options));

	//3. Display the options to html
	var options_html = "";

	for(var i=0; i<options.length; i++)
	{
		options_html += '<a href="#" onclick="del_option('+i+')">[X]</a> '+options[i]+'<br>';
	}

	$("#options_display").html(options_html);
}

var updateForm = function()
{
	var index_arr = $("#sortable").sortable("toArray");

	var new_options = [];

	for(var i=0; i<index_arr.length; i++)
	{
		new_options.push(options[index_arr[i]]);
	}

	options = new_options;

	refresh_options();
}

$(function() {
	$( "#sortable" ).sortable({update : updateForm});
});

window.onload = function () {
	if("<?=$field->type;?>" == 'dropdown')
	{
		//1. Parse the dropdown options from mysql into javascript (via json)
		options = <?=$field->options;?>;

		refresh_options();
	}
}

jQuery(document).ready(function($) {
    jQuery('a.popup').live('click', function(){
		if(changes_made)
		{
			alert("Warning, you have made some changes to the list of options for this dropdown. In order to change the order please click 'Update' and then change the order.");
			return false;
		}else{
	        newwindow=window.open($(this).attr('href'),'','height=600,width=350');
	        if (window.focus) {newwindow.focus()}
	        return false;
		}
    });
});
</script>
<?= render('settings/_nav'); ?>
<link href="<?= Uri::create('public/assets/css/jquery-sortable/jquery.ui.all.css'); ?>" rel="stylesheet" type="text/css" />
<style>
#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#sortable li { margin: 0 1px 1px 1px; padding: 1px; font-size: 1.2em; font-weight: bold; height: 1.5em; }
html>body #sortable li { height: 1.5em; line-height: 1.2em; }
.ui-state-highlight { height: 1.5em; line-height: 1.2em; }
</style>

<form action="<?= Uri::create('formfieldbuyer/edit/'.$field->id); ?>" method="POST" accept-charset="utf-8">
<input type="hidden" name="options" id="options">

<div class="widget fluid">

    <div class="whead">
		<h6>Edit Form Field</h6>
		<div class="clear"></div>
	</div>

<? if($field->type=='terms_and_conditions'): ?>

    <div class="formRow">
        <div class="grid3"><label>Type:</label></div>
        <div class="grid9">
        	Terms and Conditions
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="textarea">
        <div class="grid3"><label>Terms and Conditions that the user must agree to:</label></div>
        <div class="grid9">
			<textarea name='description'><?=$field->description;?></textarea>
		</div>
        <div class="clear"></div>
    </div>
<? else: ?>

	<?= render('formfieldbuyer/formrows/_label',array('field'=>$field)); ?>

	<?= render('formfieldbuyer/formrows/_type',array('field'=>$field)); ?>

	<?= render('formfieldbuyer/formrows/_description',array('field'=>$field)); ?>


	<? if($field->type == 'textarea'): ?>
	    <div class="formRow" id="textarea">
	        <div class="grid3"><label># of rows:</label></div>
	        <div class="grid9">
				<input type='text' name='rows' style="width: 50px;" />
			</div>
	        <div class="clear"></div>
	    </div>
	<? elseif($field->type == 'dropdown'): ?>
		<?= render('formfieldbuyer/formrows/_dropdown_options',array('field'=>$field, 'formfields_dropdowns'=>$formfields_dropdowns)); ?>

	<? endif; ?>
<? endif; ?>

	<? if(!$field->volatile): ?>
		<?= render('formfieldbuyer/formrows/_required',array('field'=>$field)); ?>
	<? endif; ?>

	<?= render('formfieldbuyer/formrows/_public',array('field'=>$field)); ?>

    <div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('formfieldbuyer'); ?>" class="buttonS bRed" style="margin: 6px 6px; color: white;">Cancel</a>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Save</button>
		</div>
		<div class="clear"></div>
    </div>

</div>
</form>
