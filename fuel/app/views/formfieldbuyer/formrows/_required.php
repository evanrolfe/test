<div class="formRow" id="public">
    <div class="grid3"><label>Required Field?</label></div>
    <div class="grid9">
		<input type="checkbox" name="required" <?if(strpos($field->validation,'required') !== false):?>checked="yes"<?endif;?> />
		<span class="note">Is this a field that the user MUST enter a value in order to submit the form?</span>
	</div>
    <div class="clear"></div>
</div>