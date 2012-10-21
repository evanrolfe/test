<div class="formRow">
    <div class="grid3"><label><?= $field->label; ?></label></div>
    <div class="grid9 noSearch" align="left">
		<textarea name="<?= $field->tag; ?>" rows="4"/><?=$value;?></textarea>
	<? if(!empty($field->description)): ?>
		<span><?=$field->description;?></span>
	<? endif;?>
	</div>
	 <div class="clear"></div>
</div>
