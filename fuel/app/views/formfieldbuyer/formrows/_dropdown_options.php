<? if($field->are_options_linked): ?>
	<input type="hidden" value="1" name="are_options_linked">
	<div class="formRow" id="dropdown">
		<div class="grid3"><label>Options are the same as this formfield:</label></div>
		<div class="grid9">
			<select class="" onchange="select_link(this.value)" name="linked_options">
				<? foreach($formfields_dropdowns as $formfield): ?>
					<? $type = ($formfield->belongs_to == 'buyer') ? 'Buyer Form' : 'Yacht Form'; ?>
					<option value="<?=$formfield->id;?>" <?if($field->linked_formfield->id == $formfield->id):?>selected="yes"<?endif;?>><?= $formfield->label; ?> (<?=$type;?>)</option>
				<? endforeach; ?>
			</select>

			<span class="note">This dropdown formfield is set to have the same options as the formfield called: "<?=$field->linked_formfield->label;?>". You may either: set this formfield to get its option from a different formfield using the dropdown box above OR edit the other formfield that it currently gets its options from by clicking on the edit button below.</span>			
		</div>
		<div class="clear"></div>
	</div>

	<? foreach($formfields_dropdowns as $formfield): ?>
	<? //Only show the formfield which has an id = $field->linked_formfield->id ?>
	<div class="formRow dropdown_opt" id="dropdown_<?=$formfield->id;?>" <? if($formfield->id != $field->linked_formfield->id): ?>style="display: none;"<? endif; ?>>
		<div class="grid3">Selected:</div>
		<div class="grid9">
			<b><?=$formfield->label;?></b> - <a href="<?=Uri::create('formfieldbuyer/edit/'.$formfield->id);?>" target="_blank">Edit</a>
			<br>
				<ul class="liDone">
				<? foreach($formfield->options as $opt): ?>
					<li><?= $opt;?></li>
				<? endforeach; ?>
				</ul>
		</div>
		<div class="clear"></div>
	</div>
	<? endforeach; ?>
<? else: ?>
	<div class="formRow" id="dropdown">
		<div class="grid3"><label>Options to choose from:</label></div>
		<div class="grid9">
			<input type='text' id="option_add_input" style="width: 150px;" />
			 <button class="buttonS bBlue" type="button" onclick="add_option()">Add</button>
			 <button class="buttonS bGreen" type="button" onclick="sort_alpha()">Sort Alphabetically</button>
			 <a href="<?=Uri::create('formfieldbuyer/dropdown/'.$field->id);?>" class="popup"><button class="buttonS bGreen" type="button">Change Order</button></a>
			<div id='options_display'>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<? endif; ?>