<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
</head>
<body>
Buyers
<p>&nbsp;</p>
<p>&nbsp;</p>
<? foreach($buyers as $buyer): ?>
<p><?= $buyer->name; ?></p>
<?= $buyer->preferences['min_loa']; ?> to <?= $buyer->preferences['max_loa']; ?>m<br />
Greece<br />
£<?= $buyer->preferences['min_budget']; ?> to £<?= $buyer->preferences['max_budget']; ?><br />
<?= $buyer->preferences['min_share_size_num']; ?>/<?= $buyer->preferences['min_share_size_den']; ?> to <?= $buyer->preferences['max_share_size_num']; ?>/<?= $buyer->preferences['max_share_size_den']; ?>
<p>Email: <a href="mailto:<?= $buyer->email; ?>"><?= $buyer->email; ?></a></p>
<p>Home: <a href="tel:<?= $buyer->preferences['tel_home']; ?>"><?= $buyer->preferences['tel_home']; ?></a></p>
<p>Work: <a href="tel:<?= $buyer->preferences['tel_work']; ?>"><?= $buyer->preferences['tel_work']; ?></a></p>
<p>Mobile: <a href="tel:<?= $buyer->preferences['tel_mobile']; ?>"><?= $buyer->preferences['tel_mobile']; ?></a></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<? endforeach; ?>
</body>
