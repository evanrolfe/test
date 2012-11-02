<?= render('yachtshare/admin/_nav',array('yachtshare' => $yachtshare)); ?>

<form action="<?= Uri::create('yachtshare/handle_post'); ?>" method="POST" accept-charset="utf-8">
<input type="hidden" name="update" value="1">
<input type="hidden" name="yachtshare_id" value="<?=$yachtshare->id;?>">
<div class="widget fluid">

    <div class="whead">
		<h6>Edit Yacht Share</h6>
		<div class="clear"></div>
	</div>

<? foreach($formfields as $field): ?>
	<? $tag = $field->tag; ?>
	<? if($field->search_field){
			$value = $yachtshare->$tag; 
		}else{
			$value = (isset($yachtshare->boat_details[$tag])) ? $yachtshare->boat_details[$tag] : '';
		} ?>

	<? if($field->type == 'text'): ?>
		<?= render('forms/_text',array('field'=>$field,'value'=>$value),false); ?>
	<? elseif($field->type == 'dropdown'): ?>
		<?= render('forms/_dropdown',array('field'=>$field,'value'=>$value),false); ?>
	<? elseif($field->type == 'textarea'): ?>
		<?= render('forms/_textarea',array('field'=>$field,'value'=>$value),false); ?>
	<? elseif($field->type == 'text_fraction'): ?>
		<? $numprop = $field->tag."_num"; $denprop = $field->tag."_den"; ?>
		<?= render('forms/_text_fraction',array('field'=>$field,'value'=>array('num' => $yachtshare->$numprop,'den' => $yachtshare->$denprop)),false); ?>
	<? elseif($field->type == 'length'): ?>
		<?= render('forms/_length',array('field'=>$field,'value'=>$value),false); ?>
	<? endif; ?>

<? endforeach; ?>

	<div class="whead">
		<h6 style="opacity: 0.0;">-</h6>
		<div style='text-align: right;'>
			<button class="buttonS bGreen" style="margin: 6px 6px;">Save</button>
		</div>
		<div class="clear"></div>
	</div>

</div>
</form>
