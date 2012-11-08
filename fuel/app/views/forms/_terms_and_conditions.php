	<div class="formRow">
	    <div class="grid3"><label><?= $field->label; ?></label></div>
	    <div class="grid9" align="left">
			<input type="checkbox" name="terms" id="" class="required">
	<? if(!empty($field->description)): ?>
		<span><?=$field->description;?></span>
	<? endif;?>
		</div>
		<div class="clear"></div>
	</div>
