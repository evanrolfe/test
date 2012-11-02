<?= render('buyer/_nav',array('buyer' => $buyer)); ?>

<form action="<?= Uri::create('buyer/handle_post/'); ?>" method="POST" accept-charset="utf-8">
<input type="hidden" name="update" value="1" />
<input type="hidden" name="buyer_id" value="<?=$buyer->id;?>" />
<div class="widget fluid">

    <div class="whead">
		<h6>Editing Buyer</h6>
		<div class="clear"></div>
	</div>

<? foreach($formfields as $field): ?>
	<? $tag = $field->tag; ?>
	<? if(in_array($field->tag,array('name','email'))){
			$value = $buyer->$tag; 
		}else{
			$value = (isset($buyer->preferences[$tag])) ? $buyer->preferences[$tag] : '';
		} ?>

	<? if($field->type == 'text'): ?>
		<?= render('forms/_text',array('field'=>$field,'value'=>$value),false); ?>
	<? elseif($field->type == 'dropdown'): ?>
		<?= render('forms/_dropdown',array('field'=>$field,'value'=>$value),false); ?>
	<? elseif($field->type == 'textarea'): ?>
		<?= render('forms/_textarea',array('field'=>$field,'value'=>$value),false); ?>
	<? elseif($field->type == 'text_fraction'): ?>
		<?= render('forms/_text_fraction',array('field'=>$field,'value'=>array('num' => $buyer->preferences[$tag.'_num'],'den' => $buyer->preferences[$tag.'_den'])),false); ?>
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
