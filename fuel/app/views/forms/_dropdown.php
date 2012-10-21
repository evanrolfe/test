	<div class="formRow">
	    <div class="grid3"><label><?= $field->label; ?></label></div>
	    <div class="grid9 noSearch" align="left">
			<select class='select' name="<?=$field->tag;?>" id="<?=$field->tag;?>" <? if(isset($width)):?>style="width: <?=$width;?>px;"<? endif; ?>>
					<option value="">Any</option>
				<? foreach($field->options as $type): ?>
					<option value="<?=$type;?>" <?if($type==$value):?>selected="yes"<?endif;?>><?=$type;?></option>
				<? endforeach; ?>
			</select>
		</div>
		<div class="clear"></div>
	</div>
