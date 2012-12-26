<div class="formRow" id="public">
	<div class="grid3"><label>Publicly viewable?</label></div>
	<div class="grid9">
		<input type="checkbox" name="public" <?if($field->public):?>checked="yes"<?endif;?> />
		<span class="note">Do you want the data users enter into this field to be viewable to the public?</span>
	</div>
	<div class="clear"></div>
</div>