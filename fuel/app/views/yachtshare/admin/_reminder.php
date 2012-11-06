<form action="<?= Uri::create('yachtshare/set_reminder'); ?>" method="POST" accept-charset="utf-8">
<input type="hidden" name="yachtshare_id" value="<?=$yachtshare->id;?>">
<input type="hidden" name="from_page" value="view">
	<!--- 1. Reminder has been set -->
	<? if($yachtshare->reminder_expires_at > 0): ?>
		<!--- 1.2 Reminder has not yet expired-->
		<? if($yachtshare->reminder_expires_at > time()): ?>

			<? if(in_array(\Request::active()->action,array('view','edit'))): ?>

				<?= render('yachtshare/admin/reminder/_set_not_expired',array('yachtshare' => $yachtshare));?>

			<? endif; ?>

		<!--- 1.3 Reminder has expired -->
		<? else: ?>

			<?= render('yachtshare/admin/reminder/_set_expired',array('yachtshare' => $yachtshare));?>

		<? endif; ?>
	<!--- 2. Reminder has not been set -->
	<? else: ?>

			<? if(in_array(\Request::active()->action,array('view','edit'))): ?>

				<?= render('yachtshare/admin/reminder/_not_set',array('yachtshare' => $yachtshare));?>

			<? endif; ?>
	<? endif; ?>

</form>
