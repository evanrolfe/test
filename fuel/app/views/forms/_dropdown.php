	<div class="formRow">
	    <div class="grid3"><label>
	    	<?= $field->label; ?>
	    	<? if(strpos($field->validation,'required') !== false):?><font color="red">*</font><?endif;?>
	    </label></div>
	    <div class="grid9" align="left">
			<select class="<?=$field->validation;?>" name="<?=$field->tag;?>" id="<?=$field->tag;?>" <? if(isset($width)):?>style="width: <?=$width;?>px;"<? endif; ?>>
					<option value="">Any</option>
				<? foreach($field->options as $type): ?>
					<option value="<?=$type;?>" <?if($type==$value):?>selected="yes"<?endif;?>><?=$type;?></option>
				<? endforeach; ?>
			</select>
	<? if(!empty($field->description)): ?>
		<span><?=$field->description;?></span>
	<? endif;?>
		</div>
		<div class="clear"></div>
	</div>
