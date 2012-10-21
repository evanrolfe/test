    <div class="whead">
		<h6>New Yacht Share</h6>
		<div class="clear"></div>
	</div>
<? foreach($formfields as $field): ?>
	<? $tag = $field->tag; ?>
	<? if($field->search_field){
			$value = $yachtshare->$tag; 
		}else{
			$value = (isset($yachtshare->boat_details[$field->tag])) ? $yachtshare->boat_details[$field->tag] : '';
		} ?>
	<? if($field->type == 'text'): ?>
	<div class="formRow">
	    <div class="grid3"><label><?= $field->label; ?></label></div>
	    <div class="grid9 noSearch" align="left">
			<input class="<?=$field->validation;?>" type='text' name="<?= $field->tag; ?>" <? if(!empty($field->options)): ?>style="width: <?=$field->options;?>px;" <? endif; ?> value="<?=$value;?>"/>
		</div>
		 <div class="clear"></div>
	</div>
	<? elseif($field->type == 'textarea'): ?>
	<div class="formRow">
	    <div class="grid3"><label><?= $field->label; ?></label></div>
	    <div class="grid9 noSearch" align="left">
			<textarea name="<?= $field->tag; ?>" rows="4"/></textarea>
		</div>
		 <div class="clear"></div>
	</div>
	<? elseif($field->type == 'dropdown'): ?>
	<div class="formRow">
	    <div class="grid3"><label><?= $field->label; ?></label></div>
	    <div class="grid9 noSearch" align="left">
			<select class='select required' name="<?=$field->tag;?>">
				<? foreach($field->options as $type): ?>
					<option value="<?=$type;?>"><?=$type;?></option>
				<? endforeach; ?>
			</select>
		</div>
		<div class="clear"></div>
	</div>
	<? elseif($field->type == 'text_fraction'): ?>
	<div class="formRow">
	    <div class="grid3"><label><?= $field->label; ?></label></div>
	    <div class="grid9 noSearch" align="left">
			<input type='text' name="<?=$field->tag;?>_numerator" style='width: 45px;' /> / <input type='text' name="<?=$field->tag;?>_denomenator" style='width: 45px;' />	
		</div>
		 <div class="clear"></div>
	</div>
	<? elseif($field->type != 'other'): ?>
	<div class="formRow">
	    <div class="grid3"><label><?= $field->label; ?></label></div>
	    <div class="grid9 noSearch" align="left">
			<input type='text' name="<?=$field->tag;?>" style="width: <?=$field->options;?>px;" />		
		</div>
		 <div class="clear"></div>
	</div>
	<? endif; ?>

<? endforeach; ?>

<script type="text/javascript">
function select_shares(n)
{
	for(var i=1; i<=10; i++)
	{
		$("#share_"+i).hide();
	}

	for(var i=1; i<=n; i++)
	{
		$("#share_"+i).show();
	}
}

</script>

    <div class="formRow">
        <div class="grid3"><label>Share Size:</label></div>
        <div class="grid9 noSearch" align="left">
			<select class="select required" onchange="select_shares(this.value)">
				<option value="">Number of Shares</option>
				<? for($i=1; $i<=10; $i++): ?>
					<option value="<?= $i; ?>"><?= $i; ?></option>
				<? endfor; ?>
			</select>

			<? for($i=1; $i<=10; $i++): ?>
				<div id="share_<?= $i; ?>" style="display: none;">Share #<?= $i; ?> <input class="number" type='text' name="share_<?= $i; ?>_numerator" style='width: 45px;' /> / <input class="number" type='text' name="share_<?= $i; ?>_denomenator" style='width: 45px;' /></div>
			<? endfor; ?>
		</div>
        <div class="clear"></div>
    </div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Save</button>
		</div>
		<div class="clear"></div>
	</div>
