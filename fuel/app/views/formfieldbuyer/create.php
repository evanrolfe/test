<script type="text/javascript">
function select_type(type)
{
	switch(type)
	{
		case "text":
			$("#text").show();
			$("#textarea").hide();
			$("#dropdown").hide();
			$("#dropdown2").hide();
		break;

		case "textarea":
			$("#text").hide();
			$("#textarea").show();
			$("#dropdown").hide();
			$("#dropdown2").hide();
		break;

		case "text_fraction":
			$("#text").hide();
			$("#textarea").hide();
			$("#dropdown").hide();
			$("#dropdown2").hide();
		break;

		case "dropdown":
			$("#text").hide();
			$("#textarea").hide();
			$("#dropdown").show();
			$("#dropdown2").show();
		break;    
	}

	$("#required").show();
	$("#public").show();
	$("#description").show();
}

function replace_tag(label)
{
	var label = label.split(" ").join("_").replace(/\W/g, '').toLowerCase();

	$("input[name=tag]").val(label);
}

var selected_options = [];

function add_option()
{
	$("#selected_options").append("<div>"+$("#option").val()+"</div>");
	selected_options.push($("#option").val());
	$("input[name=selected_options]").val(JSON.stringify(selected_options));
}
</script>
<?= render('settings/_nav'); ?>

<form action="<?= Uri::create('formfieldbuyer/create'); ?>" method="POST" accept-charset="utf-8">
<input type="hidden" name="belongs_to" value="<?=$belongs_to;?>" />
<div class="widget fluid">

    <div class="whead">
		<h6>New Buyer Form Field</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('formfieldbuyer'); ?>"><button class="buttonS bRed" style="margin: 6px 6px;" type="button">Back</button></a>
		</div>
		<div class="clear"></div>
	</div>

    <div class="formRow">
        <div class="grid3"><label>Label:</label></div>
        <div class="grid9"><input type='text' name='label' onkeyup="replace_tag(this.value)"/>
			<span class="note">This is the label for the field which will be displayed to the users.
			</span></div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Tag:</label></div>
        <div class="grid9"><input type='text' name='tag' />
			<span class="note">Value should contains NO spaces or non alpha-numeric characters. This is a technical field used by the program but whose value will not be displayed to the user. A value is automatically generated, do not modify if you are not sure of its meaning.
			</span>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow">
        <div class="grid3"><label>Type:</label></div>
        <div class="grid9">
			<select class="" onchange="select_type(this.value)" name="type">
				<option value="">Select</option>
					<option value="text">Single line text field</option>
					<option value="textarea">Mutli line text field</option>
					<option value="text_fraction">Single line text field for fractions (i.e. share size)</option>
					<option value="dropdown">Dropdown box</option>
					<option value="length">Measure of length</option>
					<option value="terms_and_conditions">Terms and conditions checkbox</option>
			</select>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="textarea" style="display: none;">
        <div class="grid3"><label># of rows:</label></div>
        <div class="grid9">
			<input type='text' name='rows' style="width: 50px;" />
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="dropdown"  style="display: none;">
        <div class="grid3"><label>Add options to the dropdown:</label></div>
        <div class="grid9">
			<input type='text' id="option" style="width: 150px;" /> <button class="buttonS bBlue" type="button" onclick="add_option()">Add</button>
			<input type='hidden' name='selected_options'>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="dropdown2"  style="display: none;">
        <div class="grid3"><label>Options:</label></div>
        <div class="grid9" id="selected_options">
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="description" style="display: none;">
        <div class="grid3"><label>Description:</label></div>
        <div class="grid9">
			<textarea name='description'></textarea>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="required" style="display: none;">
        <div class="grid3"><label>Required Field?</label></div>
        <div class="grid9">
			<input type="checkbox" name="required" />
			<span class="note">Is this a field that the user MUST enter a value in order to submit the form?</span>
		</div>
        <div class="clear"></div>
    </div>

    <div class="formRow" id="public"  style="display: none;">
        <div class="grid3"><label>Publicly viewable?</label></div>
        <div class="grid9">
			<input type="checkbox" name="public" checked="yes" />
			<span class="note">Do you want the data users enter into this field to be viewable to the public?</span>
		</div>
        <div class="clear"></div>
    </div>

    <div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right'>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Save</button>
		</div>
		<div class="clear"></div>
    </div>

</div>
</form>
