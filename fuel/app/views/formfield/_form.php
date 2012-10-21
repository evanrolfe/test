<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Key', 'key'); ?>

			<div class="input">
				<?php echo Form::input('key', Input::post('key', isset($formfield) ? $formfield->key : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Value', 'value'); ?>

			<div class="input">
				<?php echo Form::textarea('value', Input::post('value', isset($formfield) ? $formfield->value : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Type', 'type'); ?>

			<div class="input">
				<?php echo Form::input('type', Input::post('type', isset($formfield) ? $formfield->type : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Required', 'required'); ?>

			<div class="input">
				<?php echo Form::input('required', Input::post('required', isset($formfield) ? $formfield->required : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>