<script type="text/javascript">
var changes_made = false;

function select_link(id)
{
	$(".dropdown_opt").hide();
	$("#dropdown_"+id).show();
}

function replace_tag(label)
{
	var label = label.split(" ").join("_").replace(/\W/g, '').toLowerCase();

	$("input[name=tag]").val(label);
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

    <div class="formRow">
        <div class="grid3"><label>Label:</label></div>
        <div class="grid9"><input type='text' name='label' value="<?=$field->label;?>"/>
			<span class="note">This is the label for the field which will be displayed to the users.
			</span></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Type:</label></div>
        <div class="grid9">
        	<?= $field->type; ?>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="textarea">
        <div class="grid3"><label>Description:</label></div>
        <div class="grid9">
			<textarea name='description'><?=$field->description;?></textarea>
		</div>
        <div class="clear"></div>
    </div>

	<? if($field->type == 'textarea'): ?>
    <div class="formRow" id="textarea">
        <div class="grid3"><label># of rows:</label></div>
        <div class="grid9">
			<input type='text' name='rows' style="width: 50px;" />
		</div>
        <div class="clear"></div>
    </div>
	<? elseif($field->type == 'dropdown'): ?>

		<? if($field->are_options_linked): ?>
			<input type="hidden" value="1" name="are_options_linked">
			<div class="formRow" id="dropdown">
				<div class="grid3"><label>Options are the same as this formfield:</label></div>
				<div class="grid9">
					<select class="" onchange="select_link(this.value)" name="linked_options">
						<? foreach($formfields_dropdowns as $formfield): ?>
							<? $type = ($formfield->belongs_to == 'buyer') ? 'Buyer Form' : 'Yacht Form'; ?>
							<option value="<?=$formfield->id;?>" <?if($field->linked_formfield->id == $formfield->id):?>selected="yes"<?endif;?>><?= $formfield->label; ?> (<?=$type;?>)</option>
						<? endforeach; ?>
					</select>

					<span class="note">This dropdown formfield is set to have the same options as the formfield called: "<?=$field->linked_formfield->label;?>". You may either: set this formfield to get its option from a different formfield using the dropdown box above OR edit the other formfield that it currently gets its options from by clicking on the edit button below.</span>			
				</div>
				<div class="clear"></div>
			</div>

			<? foreach($formfields_dropdowns as $formfield): ?>
			<? //Only show the formfield which has an id = $field->linked_formfield->id ?>
			<div class="formRow dropdown_opt" id="dropdown_<?=$formfield->id;?>" <? if($formfield->id != $field->linked_formfield->id): ?>style="display: none;"<? endif; ?>>
				<div class="grid3">Selected:</div>
				<div class="grid9">
					<b><?=$formfield->label;?></b> - <a href="<?=Uri::create('formfieldbuyer/edit/'.$formfield->id);?>" target="_blank">Edit</a>
					<br>
						<ul class="liDone">
						<? foreach($formfield->options as $opt): ?>
							<li><?= $opt;?></li>
						<? endforeach; ?>
						</ul>
				</div>
				<div class="clear"></div>
			</div>
			<? endforeach; ?>
		<? else: ?>
			<div class="formRow" id="dropdown">
				<div class="grid3"><label>Options to choose from:</label></div>
				<div class="grid9">
					<input type='text' id="option_add_input" style="width: 150px;" />
					 <button class="buttonS bBlue" type="button" onclick="add_option()">Add</button>
					 <a href="<?=Uri::create('formfieldbuyer/dropdown/'.$field->id);?>" class="popup"><button class="buttonS bGreen" type="button">Change Order</button></a>
					<div id='options_display'>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		<? endif; ?>
	<? else: ?>
    <div class="formRow" id="textarea">
        <div class="grid3"><label>Options:</label></div>
        <div class="grid9">
			<textarea name='options'><?=$field->options;?></textarea>
		</div>
        <div class="clear"></div>
    </div>
	<? endif; ?>

    <div class="formRow" id="public">
        <div class="grid3"><label>Required Field?</label></div>
        <div class="grid9">
			<input type="checkbox" name="required" <?if(strpos($field->validation,'required') !== false):?>checked="yes"<?endif;?> />
			<span class="note">Is this a field that the user MUST enter a value in order to submit the form?</span>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="public">
        <div class="grid3"><label>Publicly viewable?</label></div>
        <div class="grid9">
			<input type="checkbox" name="public" <?if($field->public):?>checked="yes"<?endif;?> />
			<span class="note">Do you want the data users enter into this field to be viewable to the public?</span>
		</div>
        <div class="clear"></div>
    </div>

<? endif; ?>

    <div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('formfieldbuyer'); ?>"><button class="buttonS bRed" style="margin: 6px 6px;" type="button">Cancel</button></a>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Save</button>
		</div>
		<div class="clear"></div>
    </div>

</div>
</form>
