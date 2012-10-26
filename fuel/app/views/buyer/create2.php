<script type="text/javascript">
var shares = <?= $json_shares; ?>

function select_share()
{
	id = $('#interested_boats').val();

	if(id)
	{
		$("#selected_shares").show();
		$("#selected_shares_content").append(shares[id]+"<br>");
		$("#boats_interest").val($("#boats_interest").val()+id+",");
	}
}

$(document).ready(function(){
	$("#create_form").validate();
});

function save_form()
{
	var saved_form = $("#create_form").serializeArray();

	var request = $.ajax({
		url: "<?=Uri::create('session/save_form');?>",
		type: "POST",
		data: { form : saved_form},
		success: function(data) {
			$("#text_bar").html(data);
			//setTimeout(function(){ save_form(); },3000);
		}
	});
}
</script>
<div class="widget fluid" style="width: 75%;">
    <div class="whead">
		<h6>Buyer Enquiry Form</h6>
		<div style="text-align: right">
			<span id="text_bar">
			</span>
			<button class="buttonS bBlue" style="margin: 6px 6px;" onclick="save_form()" type="button">Save for Later</button>
		</div>
		<div class="clear"></div>
	</div>

<form action="<?= Uri::create('buyer/handle_post'); ?>" method="POST" accept-charset="utf-8" id="create_form">
<input type="hidden" name="insert" value="1" />
<input type="hidden" name="form_type" value="buyer">
<? foreach($fields_search as $field): ?>

	<? if($field->type == 'text'): ?>
		<?= render('forms/_text',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'dropdown'): ?>
		<?= render('forms/_dropdown',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'textarea'): ?>
		<?= render('forms/_textarea',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'text_fraction'): ?>
		<?= render('forms/_text_fraction',array('field'=>$field,'value'=>array('num' =>$saved_form_data[$field->tag.'_num'],'den' => $saved_form_data[$field->tag.'_den'])),false); ?>
	<? elseif($field->type == 'length'): ?>
		<?= render('forms/_length',array('field'=>$field,'value'=>$saved_form_data[$field->tag]),false); ?>
	<? elseif($field->type == 'terms_and_conditions'): ?>
		<?= render('forms/_terms_and_conditions',array('field'=>$field),false); ?>
	<? endif; ?>

<? endforeach; ?>

    <div class="formRow">
        <div class="grid3"><label>Select three yachts which interest you:</label></div>
        <div class="grid9 searchDrop" align="left">
			<select name="interest1" class="select">
				<option value="">Select</option>
				<? foreach($yachtshares as $share): ?>
					<option value="<?= $share->id; ?>"><?= $share->make; ?> - "<?= $share->name; ?>"</option>
				<? endforeach; ?>
			</select>
			<br>
			<select name="interest2" class="select">
				<option value="">Select</option>
				<? foreach($yachtshares as $share): ?>
					<option value="<?= $share->id; ?>"><?= $share->make; ?> - "<?= $share->name; ?>"</option>
				<? endforeach; ?>
			</select>
			<br>
			<select name="interest3" class="select">
				<option value="">Select</option>
				<? foreach($yachtshares as $share): ?>
					<option value="<?= $share->id; ?>"><?= $share->make; ?> - "<?= $share->name; ?>"</option>
				<? endforeach; ?>
			</select>
		</div>
        <div class="clear"></div>
    </div>

	<div class="formRow" id="selected_shares" style="display: none;">
	    <div class="grid3"><label>Selected Boats</label></div>
	    <div class="grid9" id="selected_shares_content" align="left">
		</div>
	    <div class="clear"></div>
	</div>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<span id="text_bar">
			</span>
			<button class="buttonS bBlue" style="margin: 6px 6px;" onclick="save_form()" type="button">Save for Later</button>
			<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Submit</button>
		</div>
		<div class="clear"></div>
	</div>
</div>
