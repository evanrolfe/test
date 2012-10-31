<script type="text/javascript">

function replace_tag(label)
{
	var label = label.split(" ").join("_").replace(/\W/g, '').toLowerCase();

	$("input[name=tag]").val(label);
}

var selected_options = [];
var options = [];

function add_option()
{
	options.push($("#option_add_input").val());
	refresh_options();
}

function del_option(index)
{
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

window.onload = function () {
	if("<?=$field->type;?>" == 'dropdown')
	{
		//1. Parse the dropdown options from mysql into javascript (via json)
		options = <?=$field->options;?>;

		refresh_options();
	}
}
</script>
<?= render('settings/_nav'); ?>

<form action="<?= Uri::create('formfieldbuyer/edit/'.$field->id); ?>" method="POST" accept-charset="utf-8">
<div class="widget fluid">

    <div class="whead">
		<h6>Edit Form Field</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('formfield'); ?>"><button class="buttonS bRed" style="margin: 6px 6px;">Back</button></a>
		</div>
		<div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>Label:</label></div>
        <div class="grid9"><input type='text' name='label' value="<?=$field->label;?>"/>
			<span>This is the label for the field which will be displayed to the users.
			</span></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Tag:</label></div>
        <div class="grid9"><input type='text' name='tag' value="<?=$field->tag;?>" />
			<span>Value should contains NO spaces or non alpha-numeric characters. This is a technical field used by the program but whose value will not be displayed to the user. A value is automatically generated, do not modify if you are not sure of its meaning.
			</span>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Type:</label></div>
        <div class="grid9 noSearch">
			<select class="select" onchange="select_type(this.value)" name="type">
					<option value="text" <?if($field->type == "text"):?>selected="yes"<?endif;?>>Single line text field</option>
					<option value="textarea" <?if($field->type == "textarea"):?>selected="yes"<?endif;?>>Mutli line text field</option>
					<option value="text_fraction" <?if($field->type == "text_fraction"):?>selected="yes"<?endif;?>>Single line text field for fractions (i.e. share size)</option>
					<option value="dropdown" <?if($field->type == "dropdown"):?>selected="yes"<?endif;?>>Dropdown box</option>

					<option value="length" <?if($field->type == "length"):?>selected="yes"<?endif;?>>Measure of length</option>
					<option value="terms_and_conditions" <?if($field->type == "terms_and_conditions"):?>selected="yes"<?endif;?>>Terms and conditions checkbox</option>
			</select>
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
	<div class="formRow" id="textarea">
	    <div class="grid3"><label>Options to choose from:</label></div>
	    <div class="grid9">
			<input type='text' id="option_add_input" style="width: 150px;" /> <button class="buttonS bBlue" type="button" onclick="add_option()">Add</button>
			<div id='options_display'>
			</div>
		</div>
	    <div class="clear"></div>
	</div>
	<div class="formRow">
	    <div class="grid3"><label>Advanced</label></div>
	    <div class="grid9">
			<input type='text' name='options' id='options'>
			<span class="note">Change the order of options as they will appear in a dropdown box. Make sure that the list follows the syntax of ["option1","option2","option3"]</span>
		</div>
	    <div class="clear"></div>
	</div>
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

    <div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Update</button>
		</div>
		<div class="clear"></div>
    </div>

</div>
</form>
