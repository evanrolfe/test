<div class="formRow">
    <div class="grid3"><label><?= $field->label; ?></label></div>
    <div class="grid9 noSearch" align="left">
		<input type='text' class="required number" name="<?=$field->tag;?>_num" style='width: 45px;' value="<?=$value['num'];?>" /> / <input class="required number" type='text' name="<?=$field->tag;?>_den" style='width: 45px;' value="<?=$value['den']?>" />
	<? if(!empty($field->description)): ?>
		<span><?=$field->description;?></span>
	<? endif;?>
	</div>
	 <div class="clear"></div>
</div>
