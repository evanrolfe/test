<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Title', 'title'); ?>

			<div class="input">
				<?php echo Form::input('title', Input::post('title', isset($actionstep) ? $actionstep->title : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Note', 'note'); ?>

			<div class="input">
				<?php echo Form::textarea('note', Input::post('note', isset($actionstep) ? $actionstep->note : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Boat share id', 'boat_share_id'); ?>

			<div class="input">
				<?php echo Form::input('boat_share_id', Input::post('boat_share_id', isset($actionstep) ? $actionstep->boat_share_id : $boat_share_id), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Buyer id', 'buyer_id'); ?>

			<div class="input">
				<?php echo Form::input('buyer_id', Input::post('buyer_id', isset($actionstep) ? $actionstep->buyer_id : $buyer_id), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>
