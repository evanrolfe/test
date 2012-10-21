<link href="<?= Uri::create('public/assets/css/jquery-sortable/jquery.ui.all.css'); ?>" rel="stylesheet" type="text/css" />
<style>
#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
#sortable li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em; }
html>body #sortable li { height: 1.5em; line-height: 1.2em; }
.ui-state-highlight { height: 1.5em; line-height: 1.2em; }
</style>

<script type="text/javascript">
	$(function() {
		$( "#sortable" ).sortable({
									update : updateForm
									});
	});

	var updateForm = function()
	{
		var serialized = $("#sortable").sortable("serialize");
		$("#order").val(serialized);
		$("#save").show();
	}
</script>

<?= render('settings/_nav'); ?>

<form action="<?= Uri::create('formfieldbuyer/order'); ?>" method="POST" accept-charset="utf-8">
<input type="hidden" id="order" name="order">

<div class="widget">
    <div class="whead">
		<h6>Listing Buyer Fields</h6>
		<div style='text-align: right'>
			<a href="<?= Uri::create('formfieldbuyer'); ?>"><button class="buttonS bRed" style="margin: 6px 6px;" type="button">Back</button></a> 
<button class="buttonS bGreen" style="margin: 6px 6px; display: none;" id="save" type="submit">Save</button>
		</div>
		<div class="clear"></div>
	</div>

	<div class="formRow">
	<? if($formfields): ?>
	<ul id="sortable">
		<? foreach($formfields as $field): ?>
		<li class="ui-state-default" id="field_<?= $field->id; ?>"><?= $field->label; ?></li>
		<? endforeach; ?>
	</ul>
	<? else: ?>
		No proforma fields available.
	<? endif; ?>
	</div>
</div>
</form>

