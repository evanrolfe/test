<?php echo Form::open(array('class' => 'form-stacked')); ?>

	<fieldset>
		<div class="clearfix">
			<?php echo Form::label('Subject', 'subject'); ?>

			<div class="input">
				<?php echo Form::input('subject', Input::post('subject', isset($emailtemplate) ? $emailtemplate->subject : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Tag', 'tag'); ?>

			<div class="input">
				<?php echo Form::input('tag', Input::post('tag', isset($emailtemplate) ? $emailtemplate->tag : ''), array('class' => 'span6')); ?>

			</div>
		</div>
		<div class="clearfix">
			<?php echo Form::label('Body', 'body'); ?>

			<div class="input">
				<?php echo Form::textarea('body', Input::post('body', isset($emailtemplate) ? $emailtemplate->body : ''), array('class' => 'span10', 'rows' => 8)); ?>

			</div>
		</div>
		<div class="actions">
			<?php echo Form::submit('submit', 'Save', array('class' => 'btn primary')); ?>

		</div>
	</fieldset>
<?php echo Form::close(); ?>