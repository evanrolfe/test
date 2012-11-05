<p>Sellers</p>
<p>&nbsp;</p>
<? foreach($yachtshares as $yachtshare): ?>
<p><?= $yachtshare->boat_details['sellers_name']; ?></p>
<p><?= $yachtshare->name; ?><br />
  <?= $yachtshare->make; ?><br />
  <?= $yachtshare->location_specific; ?><br />
  <?= $yachtshare->share_size_num; ?>/<?= $yachtshare->share_size_den; ?> share £<?= $yachtshare->price; ?></p>
<p>Email: <a href="mailto:c.rolfe@ais.at">c.rolfe@ais.at</a></p>
<p>Home: <?=$yachtshare->boat_details['telephone_home'];?></p>
<p>Work: <?=$yachtshare->boat_details['telephone_work'];?></p>
<p>Mobile: <?=$yachtshare->boat_details['telephone_mobile'];?></p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<? endforeach; ?>
