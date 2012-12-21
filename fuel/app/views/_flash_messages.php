<div style="width: 75%;">
	<? if (Session::get_flash('success')): ?>
	<div class="nNote nSuccess">
		<? echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
	</div>
	<? endif; ?>

	<? if (Session::get_flash('error')): ?>
	<div class="nNote nFailure">
		<? echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
	</div>
	<? endif; ?>
</div>