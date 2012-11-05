<div class="formRow">
    <div class="grid3"><label><?= $field->label; ?></label></div>
    <div class="grid9" align="left">
		<input type='text' class="required number" name="<?=$field->tag;?>" style='width: 45px;' value="<?=$value;?>" />
		<select class='required' name="<?=$field->tag;?>_unit" style="width: 100px;">
				<option value="m">Metres</option>
				<option value="ft">Feet</option>
		</select>
	<? if(!empty($field->description)): ?>
		<span><?=$field->description;?></span>
	<? endif;?>
	</div>
	 <div class="clear"></div>
</div>
