<div class="formRow">
    <div class="grid3" align="left"><label><?= $field->label; ?>
	    	<? if(strpos($field->validation,'required') !== false):?><font color="red">*</font><?endif;?>
    </label></div>
    <div class="grid9 noSearch" align="left">
		<textarea name="<?= $field->tag; ?>" rows="4" class="<?=$field->validation;?>"/><?=$value;?></textarea>
	<? if(!empty($field->description)): ?>
		<span><?=$field->description;?></span>
	<? endif;?>
	</div>
	 <div class="clear"></div>
</div>
