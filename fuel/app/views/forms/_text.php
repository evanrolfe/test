<? if($field->tag=='email'){ $field->validation .= " email"; } ?>
<div class="formRow">
    <div class="grid3"><label><?= $field->label; ?></label></div>
    <div class="grid9 noSearch" align="left">
		<input type='text' class="<?=$field->validation;?>" name="<?= $field->tag; ?>" <? if(!empty($field->options)): ?>style="width: <?=$field->options;?>px;" <? endif; ?> <?if($value):?>value="<?=$value;?>"<?endif;?>/>
	<? if(!empty($field->description)): ?>
		<span><?=$field->description;?></span>
	<? endif;?>
	</div>
	 <div class="clear"></div>
</div>
