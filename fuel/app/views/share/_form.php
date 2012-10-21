<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Boat id', 'boat_id'); ?>

			<div class="input">
				<?php echo Form::input('boat_id', Input::post('boat_id', isset($share) ? $share->boat_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Buyer id', 'buyer_id'); ?>

			<div class="input">
				<?php echo Form::input('buyer_id', Input::post('buyer_id', isset($share) ? $share->buyer_id : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Fraction', 'fraction'); ?>

			<div class="input">
				<?php echo Form::input('fraction', Input::post('fraction', isset($share) ? $share->fraction : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>