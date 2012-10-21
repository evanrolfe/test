<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Name', 'name'); ?>

			<div class="input">
				<?php echo Form::input('name', Input::post('name', isset($buyer) ? $buyer->name : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Email', 'email'); ?>

			<div class="input">
				<?php echo Form::input('email', Input::post('email', isset($buyer) ? $buyer->email : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<button type='submit' class="buttonS bGreen ">Save</button>
		</div>
	</fieldset>
<?php echo Form::close(); ?>
